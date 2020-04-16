<?php

class CaptchaTest extends \Tests\TestCase
{

    public function testBasicCaptchaMethodsReturnCorrectType()
    {

        $captcha = new \WebDevEtc\BlogEtc\Captcha\Basic();
        $this->assertEquals(gettype($captcha->captcha_field_name()), "string");
        $this->assertEquals(gettype($captcha->view()), "string");
        $this->assertEquals(gettype($captcha->rules()), "array");

    }

    public function testRuleCustomValidationFunctionReturnsCorrectly()
    {

        $captcha = new \WebDevEtc\BlogEtc\Captcha\Basic();

        foreach ($captcha->rules() as $rule) {

            if (is_callable($rule)) {
                // a quick hack to test that the rule (we are assuming only 1 callable rule is the one we are looking for) returns the $fail function which in this case is hard coded to return 'lookingforthis'.
                // it isn't a pretty way to do this.

                // testing WRONG answer
                $this->assertEquals($rule('wrong1', 'wrong2', function () {
                    return "lookingforthis";
                }), "lookingforthis");


                // testing CORRECT answer (should return null)
                \Config::set('blogetc.captcha.basic_answers', "ignoreme,dark,ignoreme2");
                $this->assertNull($rule('correct1', 'dark', function () {
                    return "lookingforthis";
                }));

                // testing WRONG answer
                \Config::set('blogetc.captcha.basic_answers', "ignoreme,dark,ignoreme2");
                $this->assertEquals($rule('wrong1', 'light', function () {
                    return "lookingforthis";
                }), "lookingforthis");

                // testing CORRECT answer
                \Config::set('blogetc.captcha.basic_answers', "bLAcK");
                $this->assertNull($rule('wrong1', 'black', function () {
                    return "lookingforthis";
                }));

                // testing CORRECT answer
                \Config::set('blogetc.captcha.basic_answers', "bLAcK");
                $this->assertNull($rule('wrong1', ' black', function () {
                    return "lookingforthis";
                }));


                // testing CORRECT answer
                \Config::set('blogetc.captcha.basic_answers', "ignoreme, BLACK , jgnoreme2");
                $this->assertNull($rule('wrong1', ' black', function () {
                    return "lookingforthis";
                }));
            }
        }
    }
}
