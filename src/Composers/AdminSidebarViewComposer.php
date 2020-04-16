<?php

namespace WebDevEtc\BlogEtc\Composers;

use Illuminate\View\View;
use Request;
use WebDevEtc\BlogEtc\Helpers;
use WebDevEtc\BlogEtc\Models\Category;
use WebDevEtc\BlogEtc\Models\Comment;
use WebDevEtc\BlogEtc\Models\Post;
use WebDevEtc\BlogEtc\Models\UploadedPhoto;

/**
 * View composer to provide some param used in admin's sidebar.
 */
class AdminSidebarViewComposer
{
    /**
     * Set up view parameters for the default admin panel.
     *
     * @param View $view
     */
    public function compose(View $view): void
    {
        $view->with('postCount', Post::count());
        $view->with('categoryCount', Category::count());
        $view->with('commentCount', Comment::withoutGlobalScopes()->count());
        $view->with('imageCount', UploadedPhoto::count());

        $view->with(
            'commentApprovalCount',
            Comment::withoutGlobalScopes()->where('approved', false)->count()
        );

        $view->with('hasFlashedMessage', Helpers::hasFlashedMessage());
        $view->with('flashedMessage', Helpers::pullFlashedMessage());

        $includeRichTextEditor = config('blogetc.use_wysiwyg')
            && config('blogetc.echo_html')
            && Request::routeIs(['blogetc.admin.create_post', 'blogetc.admin.edit_post']);

        $view->with('includeRichTextEditor', $includeRichTextEditor);
    }
}
