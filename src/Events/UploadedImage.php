<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogPost;

/**
 * Class UploadedImage
 * @package BinshopsBlog\Events
 */
class UploadedImage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogPost|null */
    public $BinshopsBlogPost;
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
     * @param BinshopsBlogPost $BinshopsBlogPost
     * @param $image
     * @param $source string|null  the __METHOD__  firing this event (or other string)
     */
    public function __construct(string $image_filename, $image,BinshopsBlogPost $BinshopsBlogPost=null,string $source='other')
    {
        $this->image_filename = $image_filename;
        $this->BinshopsBlogPost=$BinshopsBlogPost;
        $this->image=$image;
        $this->source=$source;
    }

}
