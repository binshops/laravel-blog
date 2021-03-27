<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogComment;

/**
 * Class CommentWillBeDeleted
 * @package BinshopsBlog\Events
 */
class CommentWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogComment */
    public $comment;

    /**
     * CommentWillBeDeleted constructor.
     * @param BinshopsBlogComment $comment
     */
    public function __construct(BinshopsBlogComment $comment)
    {
        $this->comment=$comment;
    }

}
