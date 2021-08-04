<?php

namespace BinshopsBlog\Requests;

use BinshopsBlog\Models\BinshopsField;
use BinshopsBlog\Requests\Traits\HasCategoriesTrait;

abstract class BaseBinshopsFieldValueRequest extends BaseRequest
{

    /**
     * @return string[]
     */
    public static function typesDefaultRules()
    {
        return [
            'text' => 'string',
            'textarea' => 'string',
            'number' => 'numeric',
            'date' => 'date',
            'url' => 'url'
        ];
    }

    /**
     * Shared rules for fields
     * @return array
     */
    public static function baseFieldValueRules()
    {
        $fields = BinshopsField::all();
        $rules = [];
        foreach ($fields as $field) {
            $rules[$field->name] = self::typesDefaultRules()[$field->typeName()];
            if ($field->validation !== null) {
                $rules[$field->name] .= '|' . $field->validation;
            }

            if ($field->validation == null) {
                $rules[$field->name] .= '|nullable';
            }
        }

        return $rules;
    }
}
