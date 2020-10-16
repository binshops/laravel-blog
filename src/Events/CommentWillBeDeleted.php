<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\HessamComment;

/**
 * Class CommentWillBeDeleted
 * @package WebDevEtc\BlogEtc\Events
 */
class CommentWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamComment */
    public $comment;

    /**
     * CommentWillBeDeleted constructor.
     * @param HessamComment $comment
     */
    public function __construct(HessamComment $comment)
    {
        $this->comment=$comment;
    }

}
