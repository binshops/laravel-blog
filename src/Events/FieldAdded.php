<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsField;

/**
 * Class CategoryAdded
 * @package BinshopsBlog\Events
 */
class FieldAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsField */
    public $binshopsField;

    /**
     * CategoryAdded constructor.
     * @param BinshopsField $binshopsField
     */
    public function __construct(BinshopsField $binshopsField)
    {
        $this->binshopsField = $binshopsField;
    }

}
