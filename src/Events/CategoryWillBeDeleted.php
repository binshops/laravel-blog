<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamCategory;

/**
 * Class CategoryWillBeDeleted
 * @package HessamCMS\Events
 */
class CategoryWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamCategory */
    public $hessamCMSCategory;

    /**
     * CategoryWillBeDeleted constructor.
     * @param HessamCategory $hessamCMSCategory
     */
    public function __construct(HessamCategory $hessamCMSCategory)
    {
        $this->hessamCMSCategory=$hessamCMSCategory;
    }

}
