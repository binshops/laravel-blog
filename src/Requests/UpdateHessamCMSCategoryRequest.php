<?php

namespace HessamCMS\Requests;


use Illuminate\Validation\Rule;
use HessamCMS\Models\HessamCategory;

class UpdateHessamCMSCategoryRequest extends BaseHessamCMSCategoryRequest
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
