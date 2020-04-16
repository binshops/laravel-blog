<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WebDevEtc\BlogEtc\Models\Comment;

/**
 * Class CommentWillBeDeleted.
 */
class CommentWillBeDeleted
{
    use Dispatchable, SerializesModels;

    /** @var Comment */
    public $comment;

    /**
     * CommentWillBeDeleted constructor.
     *
     * @param Comment $comment
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
}
