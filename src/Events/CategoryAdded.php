<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\HessamCategory;

/**
 * Class CategoryAdded
 * @package WebDevEtc\BlogEtc\Events
 */
class CategoryAdded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamCategory */
    public $blogEtcCategory;

    /**
     * CategoryAdded constructor.
     * @param HessamCategory $blogEtcCategory
     */
    public function __construct(HessamCategory $blogEtcCategory)
    {
        $this->blogEtcCategory=$blogEtcCategory;
    }

}
