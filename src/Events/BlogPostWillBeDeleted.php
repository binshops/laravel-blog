<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\HessamPost;

/**
 * Class BlogPostWillBeDeleted
 * @package WebDevEtc\BlogEtc\Events
 */
class BlogPostWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamPost */
    public $blogEtcPost;

    /**
     * BlogPostWillBeDeleted constructor.
     * @param HessamPost $blogEtcPost
     */
    public function __construct(HessamPost $blogEtcPost)
    {
        $this->blogEtcPost=$blogEtcPost;
    }

}
