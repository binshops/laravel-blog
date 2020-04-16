<?php

namespace WebDevEtc\BlogEtc\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\View\View;
use RuntimeException;
use WebDevEtc\BlogEtc\Models\UploadedPhoto;
use WebDevEtc\BlogEtc\Requests\UploadImageRequest;
use WebDevEtc\BlogEtc\Services\UploadsService;

/**
 * Class BlogEtcAdminController.
 *
 * @todo - a lot of this will be refactored. The public API won't change.
 */
class ManageUploadsController extends Controller
{
    /** @var UploadsService */
    private $uploadsService;

    /**
     * BlogEtcAdminController constructor.
     *
     * @param UploadsService $uploadsService
     */
    public function __construct(UploadsService $uploadsService)
    {
        $this->uploadsService = $uploadsService;

        // ensure the config file exists
        if (!is_array(config('blogetc'))) {
            throw new RuntimeException(
                'The config/blogetc.php does not exist. '.
                'Publish the vendor files for the BlogEtc package by running the php artisan publish:vendor command'
            );
        }

        if (!config('blogetc.image_upload_enabled') && !app()->runningInConsole()) {
            throw new RuntimeException('Image uploads in BlogEtc are disabled in the configuration');
        }
    }

    /**
     * Show the main listing of uploaded images.
     */
    public function index(): View
    {
        return view(
            'blogetc_admin::imageupload.index',
            [
                'uploaded_photos' => UploadedPhoto::orderBy('id', 'desc')->paginate(10),
            ]
        );
    }

    /**
     * show the form for uploading a new image.
     */
    public function create(): View
    {
        return view('blogetc_admin::imageupload.create', [
            'imageSizes' => (array) config('blogetc.image_sizes'),
        ]);
    }

    /**
     * Save a new uploaded image.
     *
     * @param UploadImageRequest $request
     *
     * @return Response
     * @throws \Exception
     */
    public function store(UploadImageRequest $request): Response
    {
        $processed_images = $this->uploadsService->processUpload(
            $request->file('upload'),
            $request->get('image_title')
        );

        return response()
            ->view('blogetc_admin::imageupload.uploaded', ['images' => $processed_images])
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
