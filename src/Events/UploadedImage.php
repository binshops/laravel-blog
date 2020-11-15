<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamPost;
use HessamCMS\Models\HessamPostTranslation;

/**
 * Class UploadedImage
 * @package HessamCMS\Events
 */
class UploadedImage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamPost|null */
    public $hessamCMSPost;
    /**
     * @var
     */
    public $image;

    public $source;
    public $image_filename;

    /**
     * UploadedImage constructor.
     *
     * @param $image_filename - the new filename
     * @param HessamPost $hessamCMSPost
     * @param $image
     * @param $source string|null  the __METHOD__  firing this event (or other string)
     */
    public function __construct(string $image_filename, $image, HessamPostTranslation $hessamCMSPost=null, string $source='other')
    {
        $this->image_filename = $image_filename;
        $this->hessamCMSPost=$hessamCMSPost;
        $this->image=$image;
        $this->source=$source;
    }

}
