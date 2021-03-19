<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsPost;

/**
 * Class BlogPostEdited
 * @package BinshopsBlog\Events
 */
class BlogPostEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsPost */
    public $binshopsBlogPost;

    /**
     * BlogPostEdited constructor.
     * @param BinshopsPost $binshopsBlogPost
     */
    public function __construct(BinshopsPost $binshopsBlogPost)
    {
        $this->binshopsBlogPost=$binshopsBlogPost;
    }

}
