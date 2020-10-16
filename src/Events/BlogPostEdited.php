<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\HessamPost;

/**
 * Class BlogPostEdited
 * @package WebDevEtc\BlogEtc\Events
 */
class BlogPostEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamPost */
    public $blogEtcPost;

    /**
     * BlogPostEdited constructor.
     * @param HessamPost $blogEtcPost
     */
    public function __construct(HessamPost $blogEtcPost)
    {
        $this->blogEtcPost=$blogEtcPost;
    }

}
