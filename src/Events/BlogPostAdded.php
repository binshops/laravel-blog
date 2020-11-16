<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamPost;

/**
 * Class BlogPostAdded
 * @package HessamCMS\Events
 */
class BlogPostAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamPost */
    public $hessamCMSPost;

    /**
     * BlogPostAdded constructor.
     * @param HessamPost $hessamCMSPost
     */
    public function __construct(HessamPost $hessamCMSPost)
    {
        $this->hessamCMSPost=$hessamCMSPost;
    }

}
