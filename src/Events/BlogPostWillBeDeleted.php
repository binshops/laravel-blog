<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamPost;

/**
 * Class BlogPostWillBeDeleted
 * @package HessamCMS\Events
 */
class BlogPostWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamPost */
    public $hessamCMSPost;

    /**
     * BlogPostWillBeDeleted constructor.
     * @param HessamPost $hessamCMSPost
     */
    public function __construct(HessamPost $hessamCMSPost)
    {
        $this->hessamCMSPost=$hessamCMSPost;
    }

}
