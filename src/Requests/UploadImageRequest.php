<?php

namespace WebDevEtc\BlogEtc\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UploadImageRequest.
 */
class UploadImageRequest extends FormRequest
{
    /**
     * Rules for uploads.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'upload' => [
                'required',
                'image',
            ],
            'image_title' => [
                'required',
                'string',
                'min:1',
                'max:150',
            ],
        ];
    }
}
