<?php

namespace HessamCMS\Requests;


use Illuminate\Validation\Rule;
use HessamCMS\Models\HessamPost;
use HessamCMS\Requests\Traits\HasCategoriesTrait;
use HessamCMS\Requests\Traits\HasImageUploadTrait;

class UpdateHessamCMSPostRequest  extends BaseHessamCMSPostRequest {

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
//        $return['slug'] [] = Rule::unique("hessam_post_translations", "slug")->ignore($this->route()->parameter("blogPostId"));
        return $return;
    }
}
