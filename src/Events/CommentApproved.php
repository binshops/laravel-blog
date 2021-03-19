<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsComment;

/**
 * Class CommentApproved
 * @package BinshopsBlog\Events
 */
class CommentApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsComment */
    public $comment;

    /**
     * CommentApproved constructor.
     * @param BinshopsComment $comment
     */
    public function __construct(BinshopsComment $comment)
    {
        $this->comment=$comment;
        // you can get the blog post via $comment->post
    }

}
