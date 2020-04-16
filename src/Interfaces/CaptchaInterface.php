<?php

namespace WebDevEtc\BlogEtc\Interfaces;

/**
 * Captcha interface to be used with the commenting system built into BlogEtc.
 * Write your own, set it in the config file.
 */
interface CaptchaInterface
{
    /**
     * What should the field name be (in the <input type='text' name='????'>).
     *
     * Note: In v4, this replaced the old captcha_field_name method
     *
     * @return string
     */
    public function captchaFieldName(): string;

    /**
     * What view file should we use for the captcha field?
     *
     * @return string
     */
    public function view(): string;

    /**
     * What rules should we use for the validation for this field?
     *
     * @return array
     */
    public function rules(): array;
}
