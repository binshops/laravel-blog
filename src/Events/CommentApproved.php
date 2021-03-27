<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogComment;

/**
 * Class CommentApproved
 * @package BinshopsBlog\Events
 */
class CommentApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogComment */
    public $comment;

    /**
     * CommentApproved constructor.
     * @param BinshopsBlogComment $comment
     */
    public function __construct(BinshopsBlogComment $comment)
    {
        $this->comment=$comment;
        // you can get the blog post via $comment->post
    }

}
