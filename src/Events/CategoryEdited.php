<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\HessamCategory;

/**
 * Class CategoryEdited
 * @package WebDevEtc\BlogEtc\Events
 */
class CategoryEdited
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  HessamCategory */
    public $blogEtcCategory;

    /**
     * CategoryEdited constructor.
     * @param HessamCategory $blogEtcCategory
     */
    public function __construct(HessamCategory $blogEtcCategory)
    {
        $this->blogEtcCategory=$blogEtcCategory;
    }

}
