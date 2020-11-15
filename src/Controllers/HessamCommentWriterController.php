<?php

namespace HessamCMS\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use HessamCMS\Captcha\CaptchaAbstract;
use HessamCMS\Captcha\UsesCaptcha;
use HessamCMS\Events\CommentAdded;
use HessamCMS\Middleware\LoadLanguage;
use HessamCMS\Middleware\UserCanManageBlogPosts;
use HessamCMS\Models\HessamComment;
use HessamCMS\Models\HessamPost;
use HessamCMS\Models\HessamPostTranslation;
use HessamCMS\Requests\AddNewCommentRequest;

/**
 * Class HessamCommentWriterController
 * @package HessamCMS\Controllers
 */
class HessamCommentWriterController extends Controller
{

    use UsesCaptcha;

    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);

    }

    /**
     * Let a guest (or logged in user) submit a new comment for a blog post
     *
     * @param AddNewCommentRequest $request
     * @param $blog_post_slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function addNewComment(AddNewCommentRequest $request, $locale, $blog_post_slug)
    {

        if (config("hessamcms.comments.type_of_comments_to_show", "built_in") !== 'built_in') {
            throw new \RuntimeException("Built in comments are disabled");
        }

        $post_translation = HessamPostTranslation::where("slug", $blog_post_slug)
            ->with('post')
            ->firstOrFail();
        $blog_post = $post_translation->post;

        /** @var CaptchaAbstract $captcha */
        $captcha = $this->getCaptchaObject();
        if ($captcha) {
            $captcha->runCaptchaBeforeAddingComment($request, $blog_post);
        }

        $new_comment = $this->createNewComment($request, $blog_post);

        return view("hessamcms::saved_comment", [
            'captcha' => $captcha,
            'blog_post' => $post_translation,
            'new_comment' => $new_comment
        ]);

    }

    /**
     * @param AddNewCommentRequest $request
     * @param $blog_post
     * @return HessamComment
     */
    protected function createNewComment(AddNewCommentRequest $request, $blog_post)
    {
        $new_comment = new HessamComment($request->all());

        if (config("hessamcms.comments.save_ip_address")) {
            $new_comment->ip = $request->ip();
        }
        if (config("hessamcms.comments.ask_for_author_website")) {
            $new_comment->author_website = $request->get('author_website');
        }
        if (config("hessamcms.comments.ask_for_author_website")) {
            $new_comment->author_email = $request->get('author_email');
        }
        if (config("hessamcms.comments.save_user_id_if_logged_in", true) && Auth::check()) {
            $new_comment->user_id = Auth::user()->id;
        }

        $new_comment->approved = config("hessamcms.comments.auto_approve_comments", true) ? true : false;

        $blog_post->comments()->save($new_comment);

        event(new CommentAdded($blog_post, $new_comment));

        return $new_comment;
    }

}
