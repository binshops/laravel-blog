<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BinshopsBlog\Middleware\LoadLanguage;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use BinshopsBlog\Models\BinshopsUploadedPhoto;
use File;
use BinshopsBlog\Requests\UploadImageRequest;
use BinshopsBlog\Traits\UploadFileTrait;

/**
 * Class BinshopsAdminController
 * @package BinshopsBlog\Controllers
 */
class BinshopsImageUploadController extends Controller
{

    use UploadFileTrait;

    /**
     * BinshopsAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);

        if (!is_array(config("binshopsblog"))) {
            throw new \RuntimeException('The config/binshopsblog.php does not exist. Publish the vendor files for the BinshopsBlog package by running the php artisan publish:vendor command');
        }


        if (!config("binshopsblog.image_upload_enabled")) {
            throw new \RuntimeException("The binshopsblog.php config option has not enabled image uploading");
        }


    }

    /**
     * Show the main listing of uploaded images
     * @return mixed
     */


    public function index()
    {
        return view("binshopsblog_admin::imageupload.index", ['uploaded_photos' => BinshopsUploadedPhoto::orderBy("id", "desc")->paginate(10)]);
    }

    /**
     * show the form for uploading a new image
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view("binshopsblog_admin::imageupload.create", []);
    }

    /**
     * Save a new uploaded image
     *
     * @param UploadImageRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(UploadImageRequest $request)
    {
        $processed_images = $this->processUploadedImages($request);

        return view("binshopsblog_admin::imageupload.uploaded", ['images' => $processed_images]);
    }

    /**
     * Process any uploaded images (for featured image)
     *
     * @param UploadImageRequest $request
     *
     * @return array returns an array of details about each file resized.
     * @throws \Exception
     * @todo - This class was added after the other main features, so this duplicates some code from the main blog post admin controller (BinshopsAdminController). For next full release this should be tided up.
     */
    protected function processUploadedImages(UploadImageRequest $request)
    {
        $this->increaseMemoryLimit();
        $photo = $request->file('upload');

        // to save in db later
        $uploaded_image_details = [];

        $sizes_to_upload = $request->get("sizes_to_upload");

        // now upload a full size - this is a special case, not in the config file. We only store full size images in this class, not as part of the featured blog image uploads.
        if (isset($sizes_to_upload['binshopsblog_full_size']) && $sizes_to_upload['binshopsblog_full_size'] === 'true') {

            $uploaded_image_details['binshopsblog_full_size'] = $this->UploadAndResize(null, $request->get("image_title"), 'fullsize', $photo);

        }

        foreach ((array)config('binshopsblog.image_sizes') as $size => $image_size_details) {

            if (!isset($sizes_to_upload[$size]) || !$sizes_to_upload[$size] || !$image_size_details['enabled']) {
                continue;
            }

            // this image size is enabled, and
            // we have an uploaded image that we can use
            $uploaded_image_details[$size] = $this->UploadAndResize(null, $request->get("image_title"), $image_size_details, $photo);
        }


        // store the image upload.
        BinshopsUploadedPhoto::create([
            'image_title' => $request->get("image_title"),
            'source' => "ImageUpload",
            'uploader_id' => optional(\Auth::user())->id,
            'uploaded_images' => $uploaded_image_details,
        ]);


        return $uploaded_image_details;

    }


}
