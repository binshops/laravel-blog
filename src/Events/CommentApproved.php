<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamComment;

/**
 * Class CommentApproved
 * @package HessamCMS\Events
 */
class CommentApproved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamComment */
    public $comment;

    /**
     * CommentApproved constructor.
     * @param HessamComment $comment
     */
    public function __construct(HessamComment $comment)
    {
        $this->comment=$comment;
        // you can get the blog post via $comment->post
    }

}
