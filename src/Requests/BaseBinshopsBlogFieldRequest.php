<?php

namespace BinshopsBlog\Requests;

use BinshopsBlog\Requests\Traits\HasCategoriesTrait;

class BaseBinshopsBlogFieldRequest extends BaseRequest
{
    use HasCategoriesTrait;

    /**
     * Shared rules for fields
     * @return array
     */
    public function rules()
    {
        return [
            'label' => ['required', 'string', 'min:1', 'max:200'],
            'type' => ['required', 'integer'],
            'validation' => ['nullable', 'string', 'min:1', 'max:5000'],
            'categories' => ['nullable', 'array'],
        ];
    }
}
