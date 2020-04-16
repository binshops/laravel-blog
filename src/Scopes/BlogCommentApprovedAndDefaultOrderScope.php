<?php

namespace WebDevEtc\BlogEtc\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class BlogCommentApprovedAndDefaultOrderScope.
 */
class BlogCommentApprovedAndDefaultOrderScope implements Scope
{
    /**
     * By default only show approved blog comments.
     * Order by id, asc - which is what we would always want when showing comments.
     * We do not support comment threads/replies.
     *
     * In the admin panel we disable this scope with ::withoutGlobalScopes() or ::withoutGlobalScope(...)
     *
     * @param Builder $builder
     * @param Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        // Comments are not paginated. Set a high number of max comments to show.
        $maxNumComments = config('blogetc.comments.max_num_of_comments_to_show', 500);

        // order in ascending order:
        $builder->orderBy('id')
            // set a sane limit on num of comments.
            ->limit($maxNumComments)
            // only show approved comments:
            ->where('approved', true);
    }
}
