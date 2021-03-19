<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsPost;

/**
 * Class BlogPostAdded
 * @package BinshopsBlog\Events
 */
class BlogPostAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsPost */
    public $binshopsBlogPost;

    /**
     * BlogPostAdded constructor.
     * @param BinshopsPost $binshopsBlogPost
     */
    public function __construct(BinshopsPost $binshopsBlogPost)
    {
        $this->binshopsBlogPost=$binshopsBlogPost;
    }

}
