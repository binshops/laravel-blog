<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsComment;
use BinshopsBlog\Models\BinshopsPost;

/**
 * Class CommentAdded
 * @package BinshopsBlog\Events
 */
class CommentAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsPost */
    public $binshopsBlogPost;
    /** @var  BinshopsComment */
    public $newComment;

    /**
     * CommentAdded constructor.
     * @param BinshopsPost $binshopsBlogPost
     * @param BinshopsComment $newComment
     */
    public function __construct(BinshopsPost $binshopsBlogPost, BinshopsComment $newComment)
    {
        $this->binshopsBlogPost=$binshopsBlogPost;
        $this->newComment=$newComment;
    }

}
