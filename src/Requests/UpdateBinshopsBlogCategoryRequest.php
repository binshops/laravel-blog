<?php

namespace BinshopsBlog\Requests;


use Illuminate\Validation\Rule;
use BinshopsBlog\Models\BinshopsBlogCategory;

class UpdateBinshopsBlogCategoryRequest extends BaseBinshopsBlogCategoryRequest
{


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = $this->baseCategoryRules();
        $return['slug'] [] = Rule::unique("binshops_blog_categories", "slug")->ignore($this->route()->parameter("categoryId"));
        return $return;

    }
}
