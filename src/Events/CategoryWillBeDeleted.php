<?php

namespace WebDevEtc\BlogEtc\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use WebDevEtc\BlogEtc\Models\Category;

/**
 * Class CategoryWillBeDeleted.
 */
class CategoryWillBeDeleted
{
    use Dispatchable, SerializesModels;

    /** @var Category */
    public $category;

    /**
     * CategoryWillBeDeleted constructor.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
}
