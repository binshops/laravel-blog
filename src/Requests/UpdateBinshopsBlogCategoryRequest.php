<?php

namespace BinshopsBlog\Requests;


use Illuminate\Validation\Rule;
use BinshopsBlog\Models\BinshopsCategory;

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
        return $return;

    }
}
