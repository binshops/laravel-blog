<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamComment;
use HessamCMS\Models\HessamPost;

/**
 * Class CommentAdded
 * @package HessamCMS\Events
 */
class CommentAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamPost */
    public $hessamCMSPost;
    /** @var  HessamComment */
    public $newComment;

    /**
     * CommentAdded constructor.
     * @param HessamPost $hessamCMSPost
     * @param HessamComment $newComment
     */
    public function __construct(HessamPost $hessamCMSPost, HessamComment $newComment)
    {
        $this->hessamCMSPost=$hessamCMSPost;
        $this->newComment=$newComment;
    }

}
