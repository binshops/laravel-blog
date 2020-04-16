<?php

namespace WebDevEtc\BlogEtc\Services;

use WebDevEtc\BlogEtc\Captcha\CaptchaAbstract;
use WebDevEtc\BlogEtc\Interfaces\CaptchaInterface;

/**
 * Class CaptchaService.
 */
class CaptchaService
{
    /**
     * Return either null (if captcha is not enabled), or the captcha object (which should implement
     * CaptchaInterface interface / extend the CaptchaAbstract class).
     *
     *
     * @return null|CaptchaAbstract
     */
    public function getCaptchaObject(): ?CaptchaInterface
    {
        if (!config('blogetc.captcha.captcha_enabled')) {
            return null;
        }

        // else: captcha is enabled
        /** @var string $captcha_class */
        $captcha_class = config('blogetc.captcha.captcha_type');

        return new $captcha_class();
    }
}
