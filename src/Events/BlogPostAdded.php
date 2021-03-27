<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogPost;

/**
 * Class BlogPostAdded
 * @package BinshopsBlog\Events
 */
class BlogPostAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogPost */
    public $BinshopsBlogPost;

    /**
     * BlogPostAdded constructor.
     * @param BinshopsBlogPost $BinshopsBlogPost
     */
    public function __construct(BinshopsBlogPost $BinshopsBlogPost)
    {
        $this->BinshopsBlogPost=$BinshopsBlogPost;
    }

}
