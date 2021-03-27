<?php

namespace BinshopsBlog\Scopes;

use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BlogCommentApprovedAndDefaultOrderScope implements Scope
{
    /**
     * By default only show approved blog comments.
     * Order by id, asc - which is what we would always want when showing comments.
     * We do not support comment threads/replies.
     *
     * In the admin panel we disable this scope with ::withoutGlobalScopes() or ::withoutGlobalScope(...)
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->orderBy("id", 'asc');
        // set a sane limit on num of comments. No pagination. Maybe a feature in the future.
        $builder->limit(config("binshopsblog.comments.max_num_of_comments_to_show", 500));
        $builder->where("approved", true);
    }
}