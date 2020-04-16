<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use WebDevEtc\BlogEtc\Models\BlogEtcCategory;

/**
 * Class CategoryWillBeDeleted
 * @package WebDevEtc\BlogEtc\Events
 */
class CategoryWillBeDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  BlogEtcCategory */
    public $blogEtcCategory;

    /**
     * CategoryWillBeDeleted constructor.
     * @param BlogEtcCategory $blogEtcCategory
     */
    public function __construct(BlogEtcCategory $blogEtcCategory)
    {
        $this->blogEtcCategory=$blogEtcCategory;
    }

}
