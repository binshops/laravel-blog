<?php

namespace WebDevEtc\BlogEtc\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class FeedRequest.
 */
class FeedRequest extends FormRequest
{
    /**
     * Rules for requesting the feed.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => [Rule::in(['rss', 'atom'])],

        ];
    }

    /**
     * Is this request for an RSS feed or Atom feed? defaults to atom.
     *
     * @return string
     */
    public function getFeedType(): string
    {
        return $this->get('type') === 'rss' ? 'rss' : 'atom';
    }
}
