<?php

namespace WebDevEtc\BlogEtc\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;
use WebDevEtc\BlogEtc\Interfaces\CaptchaInterface;
use WebDevEtc\BlogEtc\Services\CommentsService;

/**
 * Class AddNewCommentRequest.
 */
class CommentRequest extends FormRequest
{
    /**
     * Can user add new comments?
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return config('blogetc.comments.type_of_comments_to_show') === CommentsService::COMMENT_TYPE_BUILT_IN;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        // basic rules
        $return = [
            'comment'        => ['required', 'string', 'min:3', 'max:1000'],
            'author_name'    => ['string', 'min:1', 'max:50'],
            'author_email'   => ['string', 'nullable', 'min:1', 'max:254', 'email'],
            'author_website' => ['string', 'nullable', 'min:'.strlen('http://a.b'), 'max:175', 'active_url'],
        ];

        // Do we need author name?
        // If logged in and save_user_id_if_logged_in is true then it is not required. Otherwise it is required.
        $return['author_name'][] = Auth::check() && config('blogetc.comments.save_user_id_if_logged_in', true)
            ? 'nullable'
            : 'required';

        // Is captcha enabled? If so, get the rules from its class.
        if (config('blogetc.captcha.captcha_enabled')) {
            /** @var string $captcha_class */
            $captcha_class = config('blogetc.captcha.captcha_type');

            /** @var CaptchaInterface $captcha */
            $captcha = new $captcha_class();

            $return[$captcha->captchaFieldName()] = $captcha->rules();
        }

        // in case you need to implement something custom, you can use this...
        if (config('blogetc.comments.rules') && is_callable(config('blogetc.comments.rules'))) {
            /** @var callable $function */
            $function = config('blogetc.comments.rules');
            $return = $function($return);
        }

        if (config('blogetc.comments.require_author_email')) {
            $return['author_email'][] = 'required';
        }

        return $return;
    }
}
