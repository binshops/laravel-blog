<?php

namespace WebDevEtc\BlogEtc\Requests;

abstract class BaseBlogEtcCategoryRequest extends BaseRequest
{
    /**
     * Shared rules for categories
     * @return array
     */
    protected function baseCategoryRules()
    {
        $return = [
            'category_name' => ['required', 'string', 'min:1', 'max:200'],
            'slug' => ['required', 'alpha_dash', 'max:100', 'min:1'],
            'category_description' => ['nullable', 'string', 'min:1', 'max:5000'],
        ];
        return $return;
    }
}
