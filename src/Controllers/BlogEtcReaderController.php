<?php

namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Swis\Laravel\Fulltext\Search;
use WebDevEtc\BlogEtc\Captcha\UsesCaptcha;
use WebDevEtc\BlogEtc\Models\HessamCategory;
use WebDevEtc\BlogEtc\Models\HessamPost;

/**
 * Class BlogEtcReaderController
 * All of the main public facing methods for viewing blog content (index, single posts)
 * @package WebDevEtc\BlogEtc\Controllers
 */
class BlogEtcReaderController extends Controller
{
    use UsesCaptcha;

    /**
     * Show blog posts
     * If category_slug is set, then only show from that category
     *
     * @param null $category_slug
     * @return mixed
     */
    public function index($category_slug = null)
    {
        // the published_at + is_published are handled by BlogEtcPublishedScope, and don't take effect if the logged in user can manageb log posts
        $title = 'Blog Page'; // default title...

        $categoryChain = null;
        if ($category_slug) {
            $category = HessamCategory::where("slug", $category_slug)->firstOrFail();
            $categoryChain = $category->getAncestorsAndSelf();
            $posts = $category->posts()->where("blog_etc_post_categories.blog_etc_category_id", $category->id);

            // at the moment we handle this special case (viewing a category) by hard coding in the following two lines.
            // You can easily override this in the view files.
            \View::share('blogetc_category', $category); // so the view can say "You are viewing $CATEGORYNAME category posts"
            $title = 'Posts in ' . $category->category_name . " category"; // hardcode title here...
        } else {
            $posts = HessamPost::query();
        }

        $posts = $posts->where('is_published', '=', 1)->where('posted_at', '<', Carbon::now()->format('Y-m-d H:i:s'))->orderBy("posted_at", "desc")->paginate(config("blogetc.per_page", 10));

        //load categories in 3 levels
        $rootList = HessamCategory::where('parent_id' ,'=' , null)->get();
        for($i = 0 ; sizeof($rootList) > $i ; $i++){
            $rootList[$i]->loadSiblings();
            for ($j = 0 ; sizeof($rootList[$i]->siblings) > $j; $j++){
                $rootList[$i]->siblings[$j]->loadSiblings();
            }
        }

        return view("blogetc::index", [
            'category_chain' => $categoryChain,
            'categories' => $rootList,
            'posts' => $posts,
            'title' => $title,
        ]);
    }

    /**
     * Show the search results for $_GET['s']
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function search(Request $request)
    {
        if (!config("blogetc.search.search_enabled")) {
            throw new \Exception("Search is disabled");
        }
        $query = $request->get("s");
        $search = new Search();
        $search_results = $search->run($query);

        \View::share("title", "Search results for " . e($query));

        $categories = HessamCategory::all();

        return view("blogetc::search", [
                'categories' => $categories,
                'query' => $query,
                'search_results' => $search_results]
        );

    }

    /**
     * View all posts in $category_slug category
     *
     * @param Request $request
     * @param $category_slug
     * @return mixed
     */
    public function view_category($hierarchy)
    {
        $categories = explode('/', $hierarchy);
        return $this->index(end($categories));
    }

    /**
     * View a single post and (if enabled) it's comments
     *
     * @param Request $request
     * @param $blogPostSlug
     * @return mixed
     */
    public function viewSinglePost(Request $request, $blogPostSlug)
    {
        // the published_at + is_published are handled by BlogEtcPublishedScope, and don't take effect if the logged in user can manage log posts
        $blog_post = HessamPost::where("slug", $blogPostSlug)
            ->firstOrFail();

        if ($captcha = $this->getCaptchaObject()) {
            $captcha->runCaptchaBeforeShowingPosts($request, $blog_post);
        }

        return view("blogetc::single_post", [
            'post' => $blog_post,
            // the default scope only selects approved comments, ordered by id
            'comments' => $blog_post->comments()
                ->with("user")
                ->get(),
            'captcha' => $captcha,
        ]);
    }

}
