<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogComment;
use BinshopsBlog\Models\BinshopsBlogPost;

/**
 * Class CommentAdded
 * @package BinshopsBlog\Events
 */
class CommentAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogPost */
    public $BinshopsBlogPost;
    /** @var  BinshopsBlogComment */
    public $newComment;

    /**
     * CommentAdded constructor.
     * @param BinshopsBlogPost $BinshopsBlogPost
     * @param BinshopsBlogComment $newComment
     */
    public function __construct(BinshopsBlogPost $BinshopsBlogPost, BinshopsBlogComment $newComment)
    {
        $this->BinshopsBlogPost=$BinshopsBlogPost;
        $this->newComment=$newComment;
    }

}
