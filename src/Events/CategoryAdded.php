<?php

namespace HessamCMS\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use HessamCMS\Models\HessamCategory;
use HessamCMS\Models\HessamCategoryTranslation;

/**
 * Class CategoryAdded
 * @package HessamCMS\Events
 */
class CategoryAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamCategory */
    public $hessamCategory;
    public $hessamCategoryTranslation;

    /**
     * CategoryAdded constructor.
     * @param HessamCategory $hessamCategory
     */
    public function __construct(HessamCategory $hessamCategory, HessamCategoryTranslation  $hessamCategoryTranslation)
    {
        $this->hessamCategory=$hessamCategory;
        $this->hessamCategoryTranslation = $hessamCategoryTranslation;
    }

}
