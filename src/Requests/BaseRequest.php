<?php

namespace BinshopsBlog\Requests;

use Illuminate\Foundation\Http\FormRequest;
use BinshopsBlog\Interfaces\BaseRequestInterface;

/**
 * Class BaseRequest
 * @package BinshopsBlog\Requests
 */
abstract class BaseRequest extends FormRequest implements BaseRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::check() && \Auth::user()->canManageBinshopsBlogPosts();
    }
}
