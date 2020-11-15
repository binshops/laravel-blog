<?php

namespace HessamCMS\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Laravelium\Feed\Feed;
use HessamCMS\Middleware\DetectLanguage;
use HessamCMS\Models\HessamPost;
use HessamCMS\Requests\FeedRequest;

/**
 * Class HessamRssFeedController.php
 * All RSS feed viewing methods
 * @package HessamCMS\Controllers
 */
class HessamRssFeedController extends Controller
{
    public function __construct()
    {
        $this->middleware(DetectLanguage::class);
    }
    
    /**
     * @param Feed $feed
     * @param $posts
     * @return mixed
     */
    protected function setupFeed(Feed $feed, $posts)
    {
        $feed->title = config("app.name") . ' Blog';
        $feed->description = config("hessamcms.rssfeed.description", "Our blog RSS feed");
        $feed->link = route('hessamcms.index');
        $feed->setDateFormat('carbon');
        $feed->pubdate = isset($posts[0]) ? $posts[0]->posted_at : Carbon::now()->subYear(10);
        $feed->lang = config("hessamcms.rssfeed.language", "en");
        $feed->setShortening(config("hessamcms.rssfeed.should_shorten_text", true)); // true or false
        $feed->setTextLimit(config("hessamcms.rssfeed.text_limit", 100));
    }


    /**
     * @param $feed
     */
    protected function makeFreshFeed(Feed $feed)
    {
        $posts = HessamPost::orderBy("posted_at", "desc")
            ->limit(config("hessamcms.rssfeed.posts_to_show_in_rss_feed", 10))
            ->with("author")
            ->get();

        $this->setupFeed($feed, $posts);

        /** @var HessamPost $post */
        foreach ($posts as $post) {
            $feed->add($post->title,
                $post->author_string(),
                $post->url(),
                $post->posted_at,
                $post->short_description,
                $post->generate_introduction()
            );
        }
    }

    /**
     * RSS Feed
     * This is a long (but quite simple) method to show an RSS feed
     * It makes use of Laravelium\Feed\Feed.
     *
     * @param FeedRequest $request
     * @param Feed $feed
     * @return mixed
     */
    public function feed(FeedRequest $request, Feed $feed)
    {

        // if a logged in user views the RSS feed it will get cached, and if they are an admin user then it'll show all posts (even if it is not set as published)
        $user_or_guest = \Auth::check() ? \Auth::user()->id : 'guest';

        $feed->setCache(
            config("hessamcms.rssfeed.cache_in_minutes", 60),
            "hessamcms-" . $request->getFeedType() . $user_or_guest
        );

        if (!$feed->isCached()) {
            $this->makeFreshFeed($feed);
        }

        return $feed->render($request->getFeedType());
    }


}
