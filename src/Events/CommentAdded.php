<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\HessamComment;
use WebDevEtc\BlogEtc\Models\HessamPost;

/**
 * Class CommentAdded
 * @package WebDevEtc\BlogEtc\Events
 */
class CommentAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamPost */
    public $blogEtcPost;
    /** @var  HessamComment */
    public $newComment;

    /**
     * CommentAdded constructor.
     * @param HessamPost $blogEtcPost
     * @param HessamComment $newComment
     */
    public function __construct(HessamPost $blogEtcPost, HessamComment $newComment)
    {
        $this->blogEtcPost=$blogEtcPost;
        $this->newComment=$newComment;
    }

}
