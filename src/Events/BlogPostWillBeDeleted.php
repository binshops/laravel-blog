<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogPost;

/**
 * Class BlogPostWillBeDeleted
 * @package BinshopsBlog\Events
 */
class BlogPostWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogPost */
    public $BinshopsBlogPost;

    /**
     * BlogPostWillBeDeleted constructor.
     * @param BinshopsBlogPost $BinshopsBlogPost
     */
    public function __construct(BinshopsBlogPost $BinshopsBlogPost)
    {
        $this->BinshopsBlogPost=$BinshopsBlogPost;
    }

}
