<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\BlogEtcComment;

/**
 * Class CommentWillBeDeleted
 * @package WebDevEtc\BlogEtc\Events
 */
class CommentWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BlogEtcComment */
    public $comment;

    /**
     * CommentWillBeDeleted constructor.
     * @param BlogEtcComment $comment
     */
    public function __construct(BlogEtcComment $comment)
    {
        $this->comment=$comment;
    }

}
