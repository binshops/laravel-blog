<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamCategory;

/**
 * Class CategoryEdited
 * @package HessamCMS\Events
 */
class CategoryEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamCategory */
    public $hessamCMSCategory;

    /**
     * CategoryEdited constructor.
     * @param HessamCategory $hessamCMSCategory
     */
    public function __construct(HessamCategory $hessamCMSCategory)
    {
        $this->hessamCMSCategory=$hessamCMSCategory;
    }

}
