<?php namespace WebDevEtc\BlogEtc\Interfaces;

interface CaptchaInterface
{

    /**
     * What should the field name be (in the <input type='text' name='????'>)
     *
     * @return string
     */
    public function captcha_field_name();

    /**
     * What view file should we use for the captcha field?
     *
     * @return string
     */
    public function view();

    /**
     * What rules should we use for the validation for this field?
     *
     * @return array
     */
    public function rules();


//    // optional methods, which are run if method_exists($captcha,'...'):
//    //  do a search in the project to see how they are used.

//    /**
//     * executed when viewing single post
//     * @return void
//     */
//    public function runCaptchaBeforeShowingPosts();
//
//    /**
//     * executed when posting new comment
//     * @return void
//     */
//    public function runCaptchaBeforeAddingComment();

}