<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsBlogCategory;

/**
 * Class CategoryWillBeDeleted
 * @package BinshopsBlog\Events
 */
class CategoryWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsBlogCategory */
    public $BinshopsBlogCategory;

    /**
     * CategoryWillBeDeleted constructor.
     * @param BinshopsBlogCategory $BinshopsBlogCategory
     */
    public function __construct(BinshopsBlogCategory $BinshopsBlogCategory)
    {
        $this->BinshopsBlogCategory=$BinshopsBlogCategory;
    }

}
