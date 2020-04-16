<?php

namespace WebDevEtc\BlogEtc\Scopes;

use Carbon\Carbon;
use Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Class PostPublishedScope.
 */
class PostPublishedScope implements Scope
{
    /**
     * For normal users, add a global scope for BlogEtcPosts to never return unpublished posts.
     *
     * @param Builder $builder
     * @param Model   $model
     *
     * @return void
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (Gate::denies('blog-etc-admin')) {
            // user is a guest, or if logged in they can't manage blog posts
            $builder->where('is_published', true);
            $builder->where('posted_at', '<=', Carbon::now());
        }
    }
}
