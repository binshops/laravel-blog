<?php

namespace BinshopsBlog\Requests;


use Illuminate\Validation\Rule;
use BinshopsBlog\Models\BinshopsPost;
use BinshopsBlog\Requests\Traits\HasCategoriesTrait;
use BinshopsBlog\Requests\Traits\HasImageUploadTrait;

class UpdateBinshopsBlogPostRequest  extends BaseBinshopsBlogPostRequest {

    use HasCategoriesTrait;
    use HasImageUploadTrait;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $return = $this->baseBlogPostRules();
//        $return['slug'] [] = Rule::unique("binshops_post_translations", "slug")->ignore($this->route()->parameter("blogPostId"));
        return $return;
    }
}
