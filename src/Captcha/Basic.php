<?php namespace WebDevEtc\BlogEtc\Captcha;

/**
 * Class Basic
 * @package WebDevEtc\BlogEtc\Captcha
 */
class Basic extends CaptchaAbstract
{

    public function __construct()
    {
        if (!config("blogetc.captcha.basic_question") || !config("blogetc.captcha.basic_answers")) {
            throw new \DomainException("Invalid question or answers for captcha");
        }
    }

    /**
     * What should the field name be (in the <input type='text' name='????'>)
     *
     * @return string
     */
    public function captcha_field_name()
    {
        return 'captcha';
    }

    /**
     * What view file should we use for the captcha field?
     *
     * @return string
     */
    public function view()
    {
        return 'blogetc::captcha.basic';
    }

    /**
     * What rules should we use for the validation for this field?
     *
     * Enter the rules here, along with captcha validation.
     *
     * @return array
     */
    public function rules()
    {
        $check_func = function ($attribute, $value, $fail) {
            $answers = config("blogetc.captcha.basic_answers");
            // strtolower everything
            $value = strtolower(trim($value));
            $answers = strtolower($answers);
            $answers_array = array_map("trim", explode(",", $answers));
            if (!in_array($value, $answers_array, true)) {
                return $fail('The captcha field is incorrect.');

            };
        };

        return [

            'required',
            'string',
            $check_func

        ];
    }
}