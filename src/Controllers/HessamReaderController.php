<?php

namespace HessamCMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use HessamCMS\Laravel\Fulltext\Search;
use Illuminate\Http\Request;
use HessamCMS\Captcha\UsesCaptcha;
use HessamCMS\Middleware\DetectLanguage;
use HessamCMS\Models\HessamCategory;
use HessamCMS\Models\HessamLanguage;
use HessamCMS\Models\HessamPost;
use HessamCMS\Models\HessamPostTranslation;

/**
 * Class HessamReaderController
 * All of the main public facing methods for viewing blog content (index, single posts)
 * @package HessamCMS\Controllers
 */
class HessamReaderController extends Controller
{
    use UsesCaptcha;

    public function __construct()
    {
        $this->middleware(DetectLanguage::class);
    }

    /**
     * Show blog posts
     * If category_slug is set, then only show from that category
     *
     * @param null $category_slug
     * @return mixed
     */
    public function index($locale, $category_slug = null, Request $request)
    {
        // the published_at + is_published are handled by HessamCMSPublishedScope, and don't take effect if the logged in user can manageb log posts

        //todo
        $title = 'Blog Page'; // default title...

        $categoryChain = null;
        if ($category_slug) {
            $category = HessamCategory::where("slug", $category_slug)->firstOrFail();
            $categoryChain = $category->getAncestorsAndSelf();
            $posts = $category->posts()->where("blog_etc_post_categories.blog_etc_category_id", $category->id);

            // at the moment we handle this special case (viewing a category) by hard coding in the following two lines.
            // You can easily override this in the view files.
            \View::share('hessamcms_category', $category); // so the view can say "You are viewing $CATEGORYNAME category posts"
            $title = 'Posts in ' . $category->category_name . " category"; // hardcode title here...
        } else {
            $posts = HessamPostTranslation::query();
        }

//        $posts = $posts->where('is_published', '=', 1)
//            ->where('posted_at', '<', Carbon::now()->format('Y-m-d H:i:s'))
//            ->where('lang_id', $request->get("lang_id"))
//            ->orderBy("posted_at", "desc")
//            ->paginate(config("hessamcms.per_page", 10));

        $posts = HessamPostTranslation::where('lang_id', $request->get("lang_id"))
            ->with(['post' => function($query){
                $query->where("is_published" , '=' , true);
                $query->where('posted_at', '<', Carbon::now()->format('Y-m-d H:i:s'));
                $query->orderBy("posted_at", "desc");
            }])->paginate(config("hessamcms.per_page", 10));

        //load category hierarchy
        $rootList = HessamCategory::roots()->get();
        HessamCategory::loadSiblingsWithList($rootList);

        return view("hessamcms::index", [
            'lang_list' => HessamLanguage::all('locale','name'),
            'locale' => $request->get("locale"),
            'lang_id' => $request->get('lang_id'),
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
        if (!config("hessamcms.search.search_enabled")) {
            throw new \Exception("Search is disabled");
        }
        $query = $request->get("s");
        $search = new Search();
        $search_results = $search->run($query);

        \View::share("title", "Search results for " . e($query));

        $rootList = HessamCategory::roots()->get();
        HessamCategory::loadSiblingsWithList($rootList);

        return view("hessamcms::search", [
                'lang_id' => $request->get('lang_id'),
                'locale' => $request->get("locale"),
                'categories' => $rootList,
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
    public function viewSinglePost(Request $request, $locale, $blogPostSlug)
    {
        // the published_at + is_published are handled by HessamCMSPublishedScope, and don't take effect if the logged in user can manage log posts
        $blog_post = HessamPostTranslation::where([
            ["slug", "=", $blogPostSlug],
            ['lang_id', "=" , $request->get("lang_id")]
        ])->firstOrFail();

        if ($captcha = $this->getCaptchaObject()) {
            $captcha->runCaptchaBeforeShowingPosts($request, $blog_post);
        }

        return view("hessamcms::single_post", [
            'post' => $blog_post,
            // the default scope only selects approved comments, ordered by id
            'comments' => $blog_post->post->comments()
                ->with("user")
                ->get(),
            'captcha' => $captcha,
        ]);
    }

}
