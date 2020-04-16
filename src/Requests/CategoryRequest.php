<?php

namespace WebDevEtc\BlogEtc\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class BlogEtcCategoryRequest.
 */
class CategoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        if ($this->method() === Request::METHOD_DELETE) {
            // No rules are required for deleting.
            return [];
        }
        $rules = [
            'category_name'        => ['required', 'string', 'min:1', 'max:200'],
            'slug'                 => ['required', 'alpha_dash', 'max:100', 'min:1'],
            'category_description' => ['nullable', 'string', 'min:1', 'max:5000'],
        ];

        if ($this->method() === Request::METHOD_POST) {
            $rules['slug'][] = Rule::unique('blog_etc_categories', 'slug');
        }

        if (in_array($this->method(), [Request::METHOD_PUT, Request::METHOD_PATCH], true)) {
            $rules['slug'][] = Rule::unique('blog_etc_categories', 'slug')
                ->ignore($this->route()->parameter('categoryId'));
        }

        return $rules;
    }
}
