<?php namespace HessamCMS\Captcha;

use Illuminate\Http\Request;
use HessamCMS\Interfaces\CaptchaInterface;
use HessamCMS\Models\HessamPost;
use HessamCMS\Models\HessamPostTranslation;

abstract class CaptchaAbstract implements CaptchaInterface
{


    /**
     * executed when viewing single post
     *
     * @param Request $request
     * @param HessamPostTranslation $hessamCMSPost
     *
     * @return void
     */
    public function runCaptchaBeforeShowingPosts(Request $request, HessamPostTranslation $hessamCMSPost)
    {
        // no code here to run! Maybe in your subclass you can make use of this?
        /*

        But you could put something like this -
        $some_question = ...
        $correct_captcha = ...
        \View::share("correct_captcha",$some_question); // << reference this in the view file.
        \Session::put("correct_captcha",$correct_captcha);


        then in the validation rules you can check if the submitted value matched the above value. You will have to implement this.

        */
    }

    /**
     * executed when posting new comment
     *
     * @param Request $request
     * @param HessamPost $hessamCMSPost
     *
     * @return void
     */
    public function runCaptchaBeforeAddingComment(Request $request, HessamPost $hessamCMSPost)
    {
        // no code here to run! Maybe in your subclass you can make use of this?
    }

}
