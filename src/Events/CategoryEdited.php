<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogCategory;

/**
 * Class CategoryEdited
 * @package BinshopsBlog\Events
 */
class CategoryEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogCategory */
    public $BinshopsBlogCategory;

    /**
     * CategoryEdited constructor.
     * @param BinshopsBlogCategory $BinshopsBlogCategory
     */
    public function __construct(BinshopsBlogCategory $BinshopsBlogCategory)
    {
        $this->BinshopsBlogCategory=$BinshopsBlogCategory;
    }

}
