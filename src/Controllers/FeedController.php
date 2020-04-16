<?php

namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use Laravelium\Feed\Feed;
use WebDevEtc\BlogEtc\Requests\FeedRequest;
use WebDevEtc\BlogEtc\Services\FeedService;

/**
 * Class BlogEtcRssFeedController.php.
 */
class FeedController extends Controller
{
    /** @var FeedService */
    private $feedService;

    /**
     * BlogEtcRssFeedController constructor.
     *
     * @param FeedService $feedService
     */
    public function __construct(FeedService $feedService)
    {
        $this->feedService = $feedService;
    }

    /**
     * RSS Feed controller.
     *
     * @param FeedRequest $request
     * @param Feed        $feed
     *
     * @return mixed
     */
    public function index(FeedRequest $request, Feed $feed)
    {
        return $this->feedService->getFeed($feed, $request->getFeedType());
    }
}
