<?php

namespace WebDevEtc\BlogEtc\Services;

use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;
use Laravelium\Feed\Feed;
use Laravelium\Feed\view;
use WebDevEtc\BlogEtc\Models\Post;

/**
 * Class BlogEtcFeedService.
 */
class FeedService
{
    /**
     * @var PostsService
     */
    private $postsService;

    /**
     * FeedService constructor.
     *
     * @param PostsService $postsService
     */
    public function __construct(PostsService $postsService)
    {
        $this->postsService = $postsService;
    }

    /**
     * Build the Feed object and populate it with blog posts.
     *
     * @param Feed $feed
     * @param string $feedType
     *
     * @return view
     */
    public function getFeed(Feed $feed, string $feedType): Response
    {
        // RSS feed is cached. Admin/writer users might see different content, so
        // use a different cache for different users.

        // This should not be a problem unless your site has many logged in users.
        // (Use check(), as it is possible for user to be logged in without having an ID (depending on how the guard
        // is set up...)
        $userOrGuest = Auth::check()
            ? 'logged-in-'.Auth::id()
            : 'guest';

        $key = 'blogetc-'.$feedType.$userOrGuest;

        $feed->setCache(
            config('blogetc.rssfeed.cache_in_minutes', 60),
            $key
        );

        if (!$feed->isCached()) {
            $this->makeFreshFeed($feed);
        }

        return $feed->render($feedType);
    }

    /**
     * Create fresh feed by passing latest blog posts.
     *
     * @param $feed
     */
    protected function makeFreshFeed(Feed $feed): void
    {
        $blogPosts = $this->postsService->rssItems();

        $this->setupFeed(
            $feed,
            $this->pubDate($blogPosts)
        );

        /** @var Post $blogPost */
        foreach ($blogPosts as $blogPost) {
            $feed->add(
                $blogPost->title,
                $blogPost->authorString(),
                $blogPost->url(),
                $blogPost->posted_at,
                $blogPost->short_description,
                $blogPost->generateIntroduction()
            );
        }
    }

    /**
     * Basic set up of the Feed object.
     *
     * @param Feed $feed
     * @param Carbon $pubDate
     *
     * @return Feed
     */
    protected function setupFeed(Feed $feed, Carbon $pubDate): Feed
    {
        $feed->title = config('blogetc.rssfeed.title');
        $feed->description = config('blogetc.rssfeed.description');
        $feed->link = route('blogetc.index');
        $feed->lang = config('blogetc.rssfeed.language');
        $feed->setShortening(config('blogetc.rssfeed.should_shorten_text'));
        $feed->setTextLimit(config('blogetc.rssfeed.text_limit'));
        $feed->setDateFormat('carbon');
        $feed->pubdate = $pubDate;

        return $feed;
    }

    /**
     * Return the first post posted_at date, or if none exist then return today.
     *
     * @param Collection $blogPosts
     *
     * @return Carbon
     */
    protected function pubDate(Collection $blogPosts): Carbon
    {
        return $blogPosts->first()
            ? $blogPosts->first()->posted_at
            : Carbon::now();
    }
}
