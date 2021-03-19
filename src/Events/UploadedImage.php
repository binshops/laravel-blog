<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsPost;
use BinshopsBlog\Models\BinshopsPostTranslation;

/**
 * Class UploadedImage
 * @package BinshopsBlog\Events
 */
class UploadedImage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsPost|null */
    public $binshopsBlogPost;
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
     * @param BinshopsPost $binshopsBlogPost
     * @param $image
     * @param $source string|null  the __METHOD__  firing this event (or other string)
     */
    public function __construct(string $image_filename, $image, BinshopsPostTranslation $binshopsBlogPost=null, string $source='other')
    {
        $this->image_filename = $image_filename;
        $this->binshopsBlogPost=$binshopsBlogPost;
        $this->image=$image;
        $this->source=$source;
    }

}
