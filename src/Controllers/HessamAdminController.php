<?php

namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use WebDevEtc\BlogEtc\Interfaces\BaseRequestInterface;
use WebDevEtc\BlogEtc\Events\BlogPostAdded;
use WebDevEtc\BlogEtc\Events\BlogPostEdited;
use WebDevEtc\BlogEtc\Events\BlogPostWillBeDeleted;
use WebDevEtc\BlogEtc\Helpers;
use WebDevEtc\BlogEtc\Middleware\LoadLanguage;
use WebDevEtc\BlogEtc\Middleware\UserCanManageBlogPosts;
use WebDevEtc\BlogEtc\Models\HessamCategoryTranslation;
use WebDevEtc\BlogEtc\Models\HessamLanguage;
use WebDevEtc\BlogEtc\Models\HessamPost;
use WebDevEtc\BlogEtc\Models\HessamPostTranslation;
use WebDevEtc\BlogEtc\Models\HessamUploadedPhoto;
use WebDevEtc\BlogEtc\Requests\CreateBlogEtcPostRequest;
use WebDevEtc\BlogEtc\Requests\CreateHessamPostToggleRequest;
use WebDevEtc\BlogEtc\Requests\DeleteBlogEtcPostRequest;
use WebDevEtc\BlogEtc\Requests\UpdateBlogEtcPostRequest;
use WebDevEtc\BlogEtc\Traits\UploadFileTrait;

/**
 * Class HessamAdminController
 * @package WebDevEtc\BlogEtc\Controllers
 */
class HessamAdminController extends Controller
{
    use UploadFileTrait;

    /**
     * HessamAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);

        if (!is_array(config("blogetc"))) {
            throw new \RuntimeException('The config/blogetc.php does not exist. Publish the vendor files for the BlogEtc package by running the php artisan publish:vendor command');
        }
    }


    /**
     * View all posts
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $language_id = $request->cookie('language_id');
        $posts = HessamPostTranslation::orderBy("post_id", "desc")->where('lang_id', $language_id)
            ->paginate(10);

        return view("blogetc_admin::index", ['post_translations'=>$posts]);
    }

    /**
     * Show form for creating new post
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_post(Request $request)
    {
        $language_id = $request->cookie('language_id');
        $language_list = HessamLanguage::where('active',true)->get();
        $ts = HessamCategoryTranslation::where("lang_id",$language_id)->limit(1000)->get();

        return view("blogetc_admin::posts.add_post", [
            'cat_ts' => $ts,
            'language_list' => $language_list,
            'selected_lang' => $language_id,
            'post' => new \WebDevEtc\BlogEtc\Models\HessamPost(),
            'post_translation' => new \WebDevEtc\BlogEtc\Models\HessamPostTranslation(),
            'post_id' => -1
        ]);
    }

    /**
     * Save a new post - this method is called whenever add post button is clicked
     *
     * @param CreateBlogEtcPostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store_post(CreateBlogEtcPostRequest $request)
    {
        $new_blog_post = null;
        $translation = HessamPostTranslation::where(
            [
                ['post_id','=',$request['post_id']],
                ['lang_id', '=', $request['lang_id']]
            ]
        )->first();

        if ($request['post_id'] == -1 || !$translation){
            //cretes new post
            $new_blog_post = new HessamPost();
            $translation = new HessamPostTranslation();

            $new_blog_post->posted_at = Carbon::now();
        }else{
            //edits post
            $new_blog_post = HessamPost::findOrFail($translation->post_id);
        }

        $post_exists = $this->check_if_same_post_exists($request['slug'] , $request['lang_id'], $request['post_id']);
        if ($post_exists){
            Helpers::flash_message("Post already exists - try to change the slug for this language");
        }else {
            $new_blog_post->is_published = $request['is_published'];
            $new_blog_post->user_id = \Auth::user()->id;
            $new_blog_post->save();

            $translation->title = $request['title'];
            $translation->subtitle = $request['subtitle'];
            $translation->short_description = $request['short_description'];
            $translation->post_body = $request['post_body'];
            $translation->seo_title = $request['seo_title'];
            $translation->meta_desc = $request['meta_desc'];
            $translation->slug = $request['slug'];
            $translation->use_view_file = $request['use_view_file'];

            $translation->lang_id = $request['lang_id'];
            $translation->post_id = $new_blog_post->id;

            $this->processUploadedImages($request, $translation);
            $translation->save();

            $new_blog_post->categories()->sync($request->categories());
            Helpers::flash_message("Added post");
            event(new BlogPostAdded($new_blog_post));
        }

        return redirect( route('blogetc.admin.index') );
    }

    /**
     *  This method is called whenever a language is selected
     */
    public function store_post_toggle(CreateHessamPostToggleRequest $request){
        $new_blog_post = null;
        $translation = HessamPostTranslation::where(
            [
                ['post_id','=',$request['post_id']],
                ['lang_id', '=', $request['lang_id']]
            ]
        )->first();

        if (!$translation){
            $translation = new HessamPostTranslation();
        }

        if ($request['post_id'] == -1 || $request['post_id'] == null){
            //cretes new post
            $new_blog_post = new HessamPost();
            $new_blog_post->posted_at = Carbon::now();
        }else{
            //edits post
            $new_blog_post = HessamPost::findOrFail($request['post_id']);
        }

        if ($request['slug']){
            $post_exists = $this->check_if_same_post_exists($request['slug'] , $request['lang_id'], $request['post_id']);
            if ($post_exists){
                Helpers::flash_message("Post already exists - try to change the slug for this language");
            }else{
                $new_blog_post->is_published = $request['is_published'];
                $new_blog_post->user_id = \Auth::user()->id;
                $new_blog_post->save();

                $translation->title = $request['title'];
                $translation->subtitle = $request['subtitle'];
                $translation->short_description = $request['short_description'];
                $translation->post_body = $request['post_body'];
                $translation->seo_title = $request['seo_title'];
                $translation->meta_desc = $request['meta_desc'];
                $translation->slug = $request['slug'];
                $translation->use_view_file = $request['use_view_file'];

                $translation->lang_id = $request['lang_id'];
                $translation->post_id = $new_blog_post->id;

                $this->processUploadedImages($request, $translation);
                $translation->save();

                $new_blog_post->categories()->sync($request->categories());

                event(new BlogPostAdded($new_blog_post));
            }
        }

        //todo: generate event

        $language_id = $request->cookie('language_id');
        $language_list = HessamLanguage::where('active',true)->get();
        $ts = HessamCategoryTranslation::where("lang_id",$language_id)->limit(1000)->get();

        $translation = HessamPostTranslation::where(
            [
                ['post_id','=',$request['post_id']],
                ['lang_id', '=', $request['selected_lang']]
            ]
        )->first();
        if (!$translation){
            $translation = new HessamPostTranslation();
        }

        return view("blogetc_admin::posts.add_post", [
            'cat_ts' => $ts,
            'language_list' => $language_list,
            'selected_lang' => $request['selected_lang'],
            'post_translation' => $translation,
            'post' => $new_blog_post,
            'post_id' => $new_blog_post->id
        ]);
    }

    /**
     * Show form to edit post
     *
     * @param $blogPostId
     * @return mixed
     */
    public function edit_post( $blogPostId , Request $request)
    {
        $language_id = $request->cookie('language_id');

        $post_translation = HessamPostTranslation::where(
            [
                ['lang_id', '=', $language_id],
                ['post_id', '=', $blogPostId]
            ]
        )->first();

        $post = HessamPost::findOrFail($blogPostId);
        $language_list = HessamLanguage::where('active',true)->get();
        $ts = HessamCategoryTranslation::where("lang_id",$language_id)->limit(1000)->get();

        return view("blogetc_admin::posts.edit_post", [
            'cat_ts' => $ts,
            'language_list' => $language_list,
            'selected_lang' => $language_id,
            'post' => $post,
            'post_translation' => $post_translation,
            'post_id' => -1
        ]);
    }

    /**
     * Save changes to a post
     *
     * @param UpdateBlogEtcPostRequest $request
     * @param $blogPostId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update_post(UpdateBlogEtcPostRequest $request, $blogPostId)
    {
        /** @var HessamPost $post */
        $post = HessamPost::findOrFail($blogPostId);
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
        $post = HessamPost::where("slug", $postSlug)->firstOrFail();

        $path = public_path('/' . config("blogetc.blog_upload_dir"));
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
     * @param DeleteBlogEtcPostRequest $request
     * @param $blogPostId
     * @return mixed
     */
    public function destroy_post(DeleteBlogEtcPostRequest $request, $blogPostId)
    {

        $post = HessamPost::findOrFail($blogPostId);
        event(new BlogPostWillBeDeleted($post));

        $post->delete();

        // todo - delete the featured images?
        // At the moment it just issues a warning saying the images are still on the server.

        return view("blogetc_admin::posts.deleted_post")
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
    protected function processUploadedImages(BaseRequestInterface $request, HessamPostTranslation $new_blog_post)
    {
        if (!config("blogetc.image_upload_enabled")) {
            // image upload was disabled
            return;
        }

        $this->increaseMemoryLimit();

        // to save in db later
        $uploaded_image_details = [];


        foreach ((array)config('blogetc.image_sizes') as $size => $image_size_details) {

            if ($image_size_details['enabled'] && $photo = $request->get_image_file($size)) {
                // this image size is enabled, and
                // we have an uploaded image that we can use

                $uploaded_image = $this->UploadAndResize($new_blog_post, $new_blog_post->slug, $image_size_details, $photo);

                $new_blog_post->$size = $uploaded_image['filename'];
                $uploaded_image_details[$size] = $uploaded_image;
            }
        }

        // store the image upload.
        // todo: link this to the blogetc_post row.
        if (count(array_filter($uploaded_image_details))>0) {
            HessamUploadedPhoto::create([
                'source' => "BlogFeaturedImage",
                'uploaded_images' => $uploaded_image_details,
            ]);
        }
    }

    //translations for the same psots are ignored
    protected function check_if_same_post_exists($slug, $lang_id, $post_id){
        $slg = HessamPostTranslation::where(
            [
                ['slug','=', $slug],
                ['lang_id', '=', $lang_id],
                ['post_id', '<>', $post_id]
            ]
        )->first();
        if ($slg){
            return true;
        }else{
            return false;
        }
    }
}
