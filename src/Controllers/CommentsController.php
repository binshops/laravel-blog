<?php

namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;
use RuntimeException;
use WebDevEtc\BlogEtc\Requests\CommentRequest;
use WebDevEtc\BlogEtc\Services\CaptchaService;
use WebDevEtc\BlogEtc\Services\CommentsService;
use WebDevEtc\BlogEtc\Services\PostsService;

/**
 * Class BlogEtcCommentWriterController.
 *
 * Let public write comments
 */
class CommentsController extends Controller
{
    /** @var PostsService */
    private $postsService;
    /** @var CommentsService */
    private $commentsService;
    /** @var CaptchaService */
    private $captchaService;

    /**
     * BlogEtcCommentWriterController constructor.
     *
     * @param PostsService    $postsService
     * @param CommentsService $commentsService
     * @param CaptchaService  $captchaService
     */
    public function __construct(
        PostsService $postsService,
        CommentsService $commentsService,
        CaptchaService $captchaService
    ) {
        $this->postsService = $postsService;
        $this->commentsService = $commentsService;
        $this->captchaService = $captchaService;
    }

    /**
     * Let a guest (or logged in user) submit a new comment for a blog post.
     *
     * @param CommentRequest $request
     * @param $slug
     *
     * @throws Exception
     *
     * @return Factory|View
     */
    public function store(CommentRequest $request, string $slug)
    {
        if (config('blogetc.comments.type_of_comments_to_show') !== CommentsService::COMMENT_TYPE_BUILT_IN) {
            throw new RuntimeException('Built in comments are disabled');
        }

        $blogPost = $this->postsService->repository()->findBySlug($slug);

        $captcha = $this->captchaService->getCaptchaObject();

        if ($captcha) {
            $captcha->runCaptchaBeforeAddingComment($request, $blogPost);
        }

        $comment = $this->commentsService->create(
            $blogPost,
            $request->validated(),
            $request->ip(),
            Auth::id()
        );

        return response()->view('blogetc::saved_comment', [
            'captcha'     => $captcha,
            'blog_post'   => $blogPost,
            'new_comment' => $comment,
        ])->setStatusCode(Response::HTTP_CREATED);
    }
}
