<?php

namespace BinshopsBlog\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use BinshopsBlog\Models\BinshopsField;

/**
 * Class FieldWillBeDeleted
 * @package BinshopsBlog\Events
 */
class FieldWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BinshopsField */
    public $binshopsBlogField;

    /**
     * FieldWillBeDeleted constructor.
     * @param BinshopsField $binshopsBlogField
     */
    public function __construct(BinshopsField $binshopsBlogField)
    {
        $this->binshopsBlogField = $binshopsBlogField;
    }

}
