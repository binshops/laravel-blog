<?php

namespace BinshopsBlog\Requests;

use BinshopsBlog\Requests\Traits\HasCategoriesTrait;

class BaseBinshopsFieldRequest extends BaseRequest
{
    use HasCategoriesTrait;

    /**
     * Shared rules for fields
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['alpha_num', 'unique:binshops_fields,name,'. $this->id, 'string', 'min:1', 'max:200'],
            'label' => ['required', 'string', 'min:1', 'max:200'],
            'help' => ['required', 'string', 'min:1', 'max:200'],
            'type' => ['required', 'integer'],
            'validation' => ['nullable', 'string', 'min:1', 'max:5000'],
            'categories' => ['nullable', 'array'],
        ];
    }
}
