<?php

namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use LogicException;
use Swis\LaravelFulltext\Search;
use WebDevEtc\BlogEtc\Requests\SearchRequest;
use WebDevEtc\BlogEtc\Services\CaptchaService;
use WebDevEtc\BlogEtc\Services\CategoriesService;
use WebDevEtc\BlogEtc\Services\PostsService;

/**
 * Class BlogEtcReaderController
 * All of the main public facing methods for viewing blog content (index, single posts).
 */
class PostsController extends Controller
{
    /** @var PostsService */
    private $postsService;

    /** @var CategoriesService */
    private $categoriesService;

    /** @var CaptchaService */
    private $captchaService;

    /**
     * BlogEtcReaderController constructor.
     *
     * @param PostsService      $postsService
     * @param CategoriesService $categoriesService
     * @param CaptchaService    $captchaService
     */
    public function __construct(
        PostsService $postsService,
        CategoriesService $categoriesService,
        CaptchaService $captchaService
    ) {
        $this->postsService = $postsService;
        $this->categoriesService = $categoriesService;
        $this->captchaService = $captchaService;
    }

    /**
     * Show blog posts
     * If $categorySlug is set, then only show from that category.
     *
     * @param string $categorySlug
     *
     * @return mixed
     */
    public function index(string $categorySlug = null)
    {
        // the published_at + is_published are handled by BlogEtcPublishedScope, and don't take effect if the logged
        // in user can manage log posts
        $title = config('blogetc.blog_index_title'); // default title...

        // default category ID
        $categoryID = null;

        if ($categorySlug) {
            // get the category
            $category = $this->categoriesService->findBySlug($categorySlug);

            // get category ID to send to service
            $categoryID = $category->id;

            // TODO - make configurable
            $title = 'Viewing blog posts in '.$category->category_name;
        }

        $posts = $this->postsService->indexPaginated(10, $categoryID);

        return view('blogetc::index', [
            'posts'    => $posts,
            'title'    => $title,
            'category' => $category ?? null,
        ]);
    }

    /**
     * View a single post and (if enabled) comments.
     *
     * @param Request $request
     * @param $postSlug
     *
     * @return View
     */
    public function show(Request $request, $postSlug): View
    {
        $blogPost = $this->postsService->findBySlug($postSlug);

        // if using captcha, there might be some code to run now or to echo in the view:
        $usingCaptcha = $this->captchaService->getCaptchaObject();

        if ($usingCaptcha !== null) {
            $usingCaptcha->runCaptchaBeforeShowingPosts($request, $blogPost);
        }

        return view(
            'blogetc::single_post',
            [
                'post'    => $blogPost,
                'captcha' => $usingCaptcha,
                // the default scope only selects approved comments, ordered by id
                'comments' => $blogPost->comments->load('user'),
            ]
        );
    }

    /**
     * Show the search results.
     *
     * @param SearchRequest $request
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function search(SearchRequest $request): \Illuminate\Contracts\View\View
    {
        if (!config('blogetc.search.search_enabled')) {
            throw new LogicException('Search is disabled');
        }

        $query = $request->searchQuery();

        $search = new Search();
        $searchResults = $search->run($query);

        return view('blogetc::search', [
            'title'         => 'Search results for '.e($query),
            'query'         => $query,
            'searchResults' => $searchResults,
        ]);
    }

    /**
     * View all posts in $category_slug category.
     *
     * @param $categorySlug
     *
     * @return View
     */
    public function showCategory($categorySlug): \Illuminate\Contracts\View\View
    {
        return $this->index($categorySlug);
    }
}
