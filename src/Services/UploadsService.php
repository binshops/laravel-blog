<?php

namespace WebDevEtc\BlogEtc\Services;

use Auth;
use Exception;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Image;
use Intervention\Image\Constraint;
use RuntimeException;
use Storage;
use WebDevEtc\BlogEtc\Events\UploadedImage;
use WebDevEtc\BlogEtc\Models\Post;
use WebDevEtc\BlogEtc\Models\UploadedPhoto;
use WebDevEtc\BlogEtc\Repositories\UploadedPhotosRepository;
use WebDevEtc\BlogEtc\Requests\PostRequest;

/**
 * Class UploadsService.
 */
class UploadsService
{
    /**
     * How many iterations to find an available filename, before exception.
     *
     * @var int
     */
    private static $availableFilenameAttempts = 10;
    /**
     * @var UploadedPhotosRepository
     */
    private $repository;

    public function __construct(UploadedPhotosRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Disk for filesystem storage.
     *
     * Set the relevant config file to use things such as S3.
     */
    public static function disk(): Filesystem
    {
        return Storage::disk(config('blogetc.image_upload_disk', 'public'));
    }

    /**
     * Given a filename, return a public url for that asset on the filesystem as defined in the config.
     */
    public static function publicUrl(string $filename): string
    {
        return self::disk()->url(config('blogetc.blog_upload_dir').'/'.$filename);
    }

    /**
     * Handle an image upload via the upload image section (not blog post featured image).
     *
     * @param $uploadedImage
     * @param string $imageTitle
     * @return array
     * @throws Exception
     */
    public function processUpload($uploadedImage, string $imageTitle): array
    {
        // to save in db later
        $uploadedImageDetails = [];
        $this->increaseMemoryLimit();

        if (config('blogetc.image_store_full_size')) {
            // Store as full size
            $uploadedImageDetails['blogetc_full_size'] = $this->uploadAndResize(
                null,
                $imageTitle,
                'fullsize',
                $uploadedImage
            );
        }

        foreach ((array) config('blogetc.image_sizes') as $size => $imageSizeDetails) {
            $uploadedImageDetails[$size] = $this->uploadAndResize(
                null,
                $imageTitle,
                $imageSizeDetails,
                $uploadedImage
            );
        }

        // Store the image data in db:
        $this->storeInDatabase(
            null,
            $imageTitle,
            UploadedPhoto::SOURCE_IMAGE_UPLOAD,
            Auth::id(),
            $uploadedImageDetails
        );

        return $uploadedImageDetails;
    }

    /**
     * Small method to increase memory limit.
     * This can be defined in the config file. If blogetc.memory_limit is false/null then it won't do anything.
     * This is needed though because if you upload a large image it'll not work.
     */
    public function increaseMemoryLimit(): void
    {
        // increase memory - change this setting in config file
        if (config('blogetc.memory_limit')) {
            ini_set('memory_limit', config('blogetc.memory_limit'));
        }
    }

    /**
     * Resize and store an image.
     *
     * @param Post $new_blog_post
     * @param $suggested_title - used to help generate the filename
     * @param array|string $imageSizeDetails - either an array (with 'w' and 'h') or a string (and it'll be uploaded at full size,
     * no size reduction, but will use this string to generate the filename)
     * @param $photo
     *
     * @return array
     * @throws Exception
     */
    protected function uploadAndResize(
        ?Post $new_blog_post,
        $suggested_title,
        $imageSizeDetails,
        UploadedFile $photo
    ): array {
        // get the filename/filepath
        $image_filename = $this->getImageFilename($suggested_title, $imageSizeDetails, $photo);
        $destinationPath = $this->imageDestinationPath();

        // make image
        $resizedImage = Image::make($photo->getRealPath());

        if (is_array($imageSizeDetails)) {
            // resize to these dimensions:
            $w = $imageSizeDetails['w'];
            $h = $imageSizeDetails['h'];

            if (isset($imageSizeDetails['crop']) && $imageSizeDetails['crop']) {
                $resizedImage = $resizedImage->fit($w, $h);
            } else {
                $resizedImage = $resizedImage->resize($w, $h, static function (Constraint $constraint) {
                    $constraint->aspectRatio();
                });
            }
        } elseif ($imageSizeDetails === 'fullsize') {
            // nothing to do here - no resizing needed.
            // We just need to set $w/$h with the original w/h values
            $w = $resizedImage->width();
            $h = $resizedImage->height();
        } else {
            throw new RuntimeException('Invalid image_size_details value of '.$imageSizeDetails);
        }

        // What image quality to use?
        $imageQuality = config('blogetc.image_quality', 80);

        // What format (e.g. .jpg):
        $format = pathinfo($image_filename, PATHINFO_EXTENSION);

        // Get the image data to store:
        $resizedImageData = $resizedImage->encode($format, $imageQuality);

        // Store on Laravel filesystem:
        $this::disk()->put($destinationPath.'/'.$image_filename, $resizedImageData);

        // fire UploadedImage event:
        event(new UploadedImage($image_filename, $resizedImage, $new_blog_post, __METHOD__));

        // return the filename and w/h details
        return [
            'filename' => $image_filename,
            'w' => $w,
            'h' => $h,
        ];
    }

    /**
     * Get a filename (that doesn't exist) on the filesystem.
     *
     * @param string $suggested_title
     * @param $image_size_details - either an array (with w/h attributes) or a string
     * @param UploadedFile $photo
     *
     * @return string
     * @throws RuntimeException
     */
    protected function getImageFilename(string $suggested_title, $image_size_details, UploadedFile $photo): string
    {
        $base = $this->baseFilename($suggested_title);

        // $wh will be something like "-1200x300"
        $wh = $this->getDimensions($image_size_details);
        $ext = '.'.$photo->getClientOriginalExtension();

        for ($i = 1; $i <= self::$availableFilenameAttempts; $i++) {
            // add suffix if $i>1
            $suffix = $i > 1 ? '-'.Str::random(5) : '';

            $attempt = Str::slug($base.$suffix.$wh).$ext;

            if (!$this::disk()->exists($this->imageDestinationPath().'/'.$attempt)) {
                // filename doesn't exist, let's use it!
                return $attempt;
            }
        }

        // too many attempts...
        throw new RuntimeException("Unable to find a free filename after $i attempts - aborting now.");
    }

    /**
     * @param string $suggestedTitle
     *
     * @return string
     */
    protected function baseFilename(string $suggestedTitle): string
    {
        $base = substr($suggestedTitle, 0, 100);

        return $base ?: 'image-'.Str::random(5);
    }

    /**
     * Get the width and height as a string, with x between them
     * (123x456).
     *
     * It will always be prepended with '-'
     *
     * Example return value: -123x456
     *
     * $image_size_details should either be an array with two items ([$width, $height]),
     * or a string.
     *
     * If an array is given:
     * getWhForFilename([123,456]) it will return "-123x456"
     *
     * If a string is given:
     * getWhForFilename("some string") it will return -some-string". (max len: 30)
     *
     * @param array|string $imageSize
     *
     * @return string
     * @throws RuntimeException
     */
    protected function getDimensions($imageSize): string
    {
        if (is_array($imageSize)) {
            return '-'.$imageSize['w'].'x'.$imageSize['h'];
        }

        if (is_string($imageSize)) {
            return '-'.Str::slug(substr($imageSize, 0, 30));
        }

        // was not a string or array, so error
        throw new RuntimeException('Invalid image_size_details: must be an array with w and h, or a string');
    }

    /**
     * @return string
     * @throws RuntimeException
     */
    protected function imageDestinationPath(): string
    {
        return config('blogetc.blog_upload_dir');
    }

    /**
     * Store new image upload meta data in database.
     *
     * @param int|null $blogPostID
     * @param string $imageTitle
     * @param string $source
     * @param int|null $uploaderID
     * @param array $uploadedImages
     *
     * @return UploadedPhoto
     */
    protected function storeInDatabase(
        ?int $blogPostID,
        string $imageTitle,
        string $source,
        ?int $uploaderID,
        array $uploadedImages
    ): UploadedPhoto {
        // store the image upload.
        return $this->repository->create([
            'blog_etc_post_id' => $blogPostID,
            'image_title' => $imageTitle,
            'source' => $source,
            'uploader_id' => $uploaderID,
            'uploaded_images' => $uploadedImages,
        ]);
    }

    /**
     * Process any uploaded images (for featured image).
     *
     * @param PostRequest $request
     * @param Post $new_blog_post
     *
     * @return array|null
     *
     * @throws Exception
     *
     * @todo - next full release, tidy this up!
     */
    public function processFeaturedUpload(PostRequest $request, Post $new_blog_post): ?array
    {
        if (!config('blogetc.image_upload_enabled')) {
            // image upload was disabled
            return null;
        }

        $newSizes = [];
        $this->increaseMemoryLimit();

        // to save in db later
        $uploaded_image_details = [];

        $enabledImageSizes = collect((array) config('blogetc.image_sizes'))
            ->filter(function ($size) {
                return !empty($size['enabled']);
            });

        foreach ($enabledImageSizes as $size => $image_size_details) {
            $photo = $request->getImageSize($size);

            if (!$photo) {
                continue;
            }

            $uploaded_image = $this->uploadAndResize(
                $new_blog_post,
                $new_blog_post->title,
                $image_size_details,
                $photo
            );

            $newSizes[$size] = $uploaded_image['filename'];

            $uploaded_image_details[$size] = $uploaded_image;
        }

        // store the image upload.
        if (empty($newSizes)) {
            // Nothing to do if there were no sizes in config.
            return null;
        }

        // todo: link this to the blogetc_post row.
        $this->storeInDatabase(
            $new_blog_post->id,
            $new_blog_post->title,
            UploadedPhoto::SOURCE_FEATURED_IMAGE,
            Auth::id(),
            $uploaded_image_details
        );

        return $newSizes;
    }
}
