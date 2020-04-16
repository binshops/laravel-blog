<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WebDevEtc\BlogEtc\Models\Comment;
use WebDevEtc\BlogEtc\Models\Post;

/**
 * Class CommentAdded.
 */
class CommentAdded
{
    use Dispatchable, SerializesModels;

    /** @var Post */
    public $post;

    /** @var Comment */
    public $newComment;

    /**
     * CommentAdded constructor.
     *
     * @param Post    $post
     * @param Comment $newComment
     */
    public function __construct(Post $post, Comment $newComment)
    {
        $this->post = $post;
        $this->newComment = $newComment;
    }
}
