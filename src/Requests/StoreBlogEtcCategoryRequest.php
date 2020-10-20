<?php
namespace WebDevEtc\BlogEtc\Requests;


use Illuminate\Validation\Rule;

class StoreBlogEtcCategoryRequest extends BaseBlogEtcCategoryRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = $this->baseCategoryRules();
        $return['slug'] [] = Rule::unique("hessam_category_translations", "slug");
        return $return;
    }
}
