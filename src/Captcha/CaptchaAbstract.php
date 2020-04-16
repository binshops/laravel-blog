<?php

namespace WebDevEtc\BlogEtc\Captcha;

use Illuminate\Http\Request;
use WebDevEtc\BlogEtc\Interfaces\CaptchaInterface;
use WebDevEtc\BlogEtc\Models\Post;

/**
 * Class CaptchaAbstract.
 */
abstract class CaptchaAbstract implements CaptchaInterface
{
    /**
     * executed when viewing single post.
     *
     * @param Request $request
     * @param Post    $blogEtcPost
     *
     * @return mixed|void
     */
    public function runCaptchaBeforeShowingPosts(Request $request, Post $blogEtcPost)
    {
        /*
        No code here to run! Maybe in your subclass you can make use of this?

        But you could put something like this -
        $some_question = ...
        $correct_captcha = ...
        View::share("correct_captcha", $someQuestion); // << reference this in the view file.
        Session::put("correct_captcha",$correctCaptcha);

        ...then in the validation rules you can check if the submitted value matched the above value.
        */
    }

    /**
     * executed when posting new comment.
     *
     * @param Request $request
     * @param Post    $blogEtcPost
     *
     * @return void|mixed
     */
    public function runCaptchaBeforeAddingComment(Request $request, Post $blogEtcPost)
    {
        // no code here to run! Maybe in your subclass you can make use of this?
    }
}
