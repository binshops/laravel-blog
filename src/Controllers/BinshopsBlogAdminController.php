<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use BinshopsBlog\Interfaces\BaseRequestInterface;
use BinshopsBlog\Events\BlogPostAdded;
use BinshopsBlog\Events\BlogPostEdited;
use BinshopsBlog\Events\BlogPostWillBeDeleted;
use BinshopsBlog\Helpers;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use BinshopsBlog\Models\BinshopsBlogPost;
use BinshopsBlog\Models\BinshopsBlogUploadedPhoto;
use BinshopsBlog\Requests\CreateBinshopsBlogPostRequest;
use BinshopsBlog\Requests\DeleteBinshopsBlogPostRequest;
use BinshopsBlog\Requests\UpdateBinshopsBlogPostRequest;
use BinshopsBlog\Traits\UploadFileTrait;

/**
 * Class BinshopsBlogAdminController
 * @package BinshopsBlog\Controllers
 */
class BinshopsBlogAdminController extends Controller
{
    use UploadFileTrait;

    /**
     * BinshopsBlogAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);

        if (!is_array(config("binshopsblog"))) {
            throw new \RuntimeException('The config/binshopsblog.php does not exist. Publish the vendor files for the Binshops Blog package by running the php artisan publish:vendor command');
        }
    }


    /**
     * View all posts
     *
     * @return mixed
     */
    public function index()
    {
        $posts = BinshopsBlogPost::orderBy("posted_at", "desc")
            ->paginate(10);

        return view("binshopsblog_admin::index", ['posts'=>$posts]);
    }

    /**
     * Show form for creating new post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_post()
    {
        return view("binshopsblog_admin::posts.add_post");
    }

    /**
     * Save a new post
     *
     * @param CreateBinshopsBlogPostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store_post(CreateBinshopsBlogPostRequest $request)
    {
        $new_blog_post = new BinshopsBlogPost($request->all());

        $this->processUploadedImages($request, $new_blog_post);

        if (!$new_blog_post->posted_at) {
            $new_blog_post->posted_at = Carbon::now();
        }

        $new_blog_post->user_id = \Auth::user()->id;
        $new_blog_post->save();

        $new_blog_post->categories()->sync($request->categories());

        Helpers::flash_message("Added post");
        event(new BlogPostAdded($new_blog_post));
        return redirect($new_blog_post->edit_url());
    }

    /**
     * Show form to edit post
     *
     * @param $blogPostId
     * @return mixed
     */
    public function edit_post( $blogPostId)
    {
        $post = BinshopsBlogPost::findOrFail($blogPostId);
        return view("binshopsblog_admin::posts.edit_post")->withPost($post);
    }

    /**
     * Save changes to a post
     *
     * @param UpdateBinshopsBlogPostRequest $request
     * @param $blogPostId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update_post(UpdateBinshopsBlogPostRequest $request, $blogPostId)
    {
        /** @var BinshopsBlogPost $post */
        $post = BinshopsBlogPost::findOrFail($blogPostId);
        $post->fill($request->all());

        $this->processUploadedImages($request, $post);

        $post->save();
        $post->categories()->sync($request->categories());

        Helpers::flash_message("Updated post");
        event(new BlogPostEdited($post));

        return redirect($post->edit_url());

    }

    public function remove_photo($postSlug)
    {
        $post = BinshopsBlogPost::where("slug", $postSlug)->firstOrFail();

        $path = public_path('/' . config("binshopsblog.blog_upload_dir"));
        if (!$this->checked_blog_image_dir_is_writable) {
            if (!is_writable($path)) {
                throw new \RuntimeException("Image destination path is not writable ($path)");
            }
        }

        $destinationPath = $this->image_destination_path();

        if (file_exists($destinationPath.'/'.$post->image_large)) {
            unlink($destinationPath.'/'.$post->image_large);
        }

        if (file_exists($destinationPath.'/'.$post->image_medium)) {
            unlink($destinationPath.'/'.$post->image_medium);
        }

        if (file_exists($destinationPath.'/'.$post->image_thumbnail)) {
            unlink($destinationPath.'/'.$post->image_thumbnail);
        }

        $post->image_large = null;
        $post->image_medium = null;
        $post->image_thumbnail = null;
        $post->save();

        Helpers::flash_message("Photo removed");

        return redirect($post->edit_url());
    }

    /**
     * Delete a post
     *
     * @param DeleteBinshopsBlogPostRequest $request
     * @param $blogPostId
     * @return mixed
     */
    public function destroy_post(DeleteBinshopsBlogPostRequest $request, $blogPostId)
    {

        $post = BinshopsBlogPost::findOrFail($blogPostId);
        event(new BlogPostWillBeDeleted($post));

        $post->delete();

        // todo - delete the featured images?
        // At the moment it just issues a warning saying the images are still on the server.

        return view("binshopsblog_admin::posts.deleted_post")
            ->withDeletedPost($post);

    }

    /**
     * Process any uploaded images (for featured image)
     *
     * @param BaseRequestInterface $request
     * @param $new_blog_post
     * @throws \Exception
     * @todo - next full release, tidy this up!
     */
    protected function processUploadedImages(BaseRequestInterface $request, BinshopsBlogPost $new_blog_post)
    {
        if (!config("binshopsblog.image_upload_enabled")) {
            // image upload was disabled
            return;
        }

        $this->increaseMemoryLimit();

        // to save in db later
        $uploaded_image_details = [];


        foreach ((array)config('binshopsblog.image_sizes') as $size => $image_size_details) {

            if ($image_size_details['enabled'] && $photo = $request->get_image_file($size)) {
                // this image size is enabled, and
                // we have an uploaded image that we can use

                $uploaded_image = $this->UploadAndResize($new_blog_post, $new_blog_post->slug, $image_size_details, $photo);

                $new_blog_post->$size = $uploaded_image['filename'];
                $uploaded_image_details[$size] = $uploaded_image;
            }
        }

        // store the image upload.
        // todo: link this to the BinshopsBlog_post row.
        if (count(array_filter($uploaded_image_details))>0) {
            BinshopsBlogUploadedPhoto::create([
                'source' => "BlogFeaturedImage",
                'uploaded_images' => $uploaded_image_details,
            ]);
        }
    }
}
