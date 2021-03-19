<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsCategory;

/**
 * Class CategoryEdited
 * @package BinshopsBlog\Events
 */
class CategoryEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsCategory */
    public $binshopsBlogCategory;

    /**
     * CategoryEdited constructor.
     * @param BinshopsCategory $binshopsBlogCategory
     */
    public function __construct(BinshopsCategory $binshopsBlogCategory)
    {
        $this->binshopsBlogCategory=$binshopsBlogCategory;
    }

}
