<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogPost;

/**
 * Class BlogPostEdited
 * @package BinshopsBlog\Events
 */
class BlogPostEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogPost */
    public $BinshopsBlogPost;

    /**
     * BlogPostEdited constructor.
     * @param BinshopsBlogPost $BinshopsBlogPost
     */
    public function __construct(BinshopsBlogPost $BinshopsBlogPost)
    {
        $this->BinshopsBlogPost=$BinshopsBlogPost;
    }

}
