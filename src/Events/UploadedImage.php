<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\BlogEtcPost;

/**
 * Class UploadedImage
 * @package WebDevEtc\BlogEtc\Events
 */
class UploadedImage
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BlogEtcPost|null */
    public $blogEtcPost;
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
     * @param BlogEtcPost $blogEtcPost
     * @param $image
     * @param $source string|null  the __METHOD__  firing this event (or other string)
     */
    public function __construct(string $image_filename, $image,BlogEtcPost $blogEtcPost=null,string $source='other')
    {
        $this->image_filename = $image_filename;
        $this->blogEtcPost=$blogEtcPost;
        $this->image=$image;
        $this->source=$source;
    }

}
