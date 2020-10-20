<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\HessamCategory;
use WebDevEtc\BlogEtc\Models\HessamCategoryTranslation;

/**
 * Class CategoryAdded
 * @package WebDevEtc\BlogEtc\Events
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
