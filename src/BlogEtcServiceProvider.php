<?php

namespace WebDevEtc\BlogEtc;

use Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use LogicException;
use View;
use WebDevEtc\BlogEtc\Composers\AdminSidebarViewComposer;
use WebDevEtc\BlogEtc\Models\Post;

//use Swis\LaravelFulltext\ModelObserver;

/**
 * Class BlogEtcServiceProvider.
 */
class BlogEtcServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the BlogEtcPost services.
     *
     * @return void
     */
    public function boot(): void
    {
        // if full text is not enabled, disable it:
        $this->disableFulltextSyncing();

        // Include routes:
        $this->includeRoutes();

        // For vendor:publish:
        $this->publishFiles();

        // Set up default gates to allow/disallow access to features.
        $this->setupDefaultGates();

        // Set up view composer for admin views.
        $this->setupViewComposer();
    }

    /**
     * Set up view composers so admin views have required view params.
     */
    protected function setupViewComposer(): void
    {
        View::composer(
            'blogetc_admin::layouts.admin_layout',
            AdminSidebarViewComposer::class
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // for the admin backend views ( view("blogetc_admin::some-blade-file") )
        $this->loadViewsFrom(__DIR__.'/Views/blogetc_admin', 'blogetc_admin');

        // for public facing views (view("blogetc::some-blade-file")):
        // if you do the vendor:publish, these will be copied to /resources/views/vendor/blogetc.
        $this->loadViewsFrom(__DIR__.'/Views/blogetc', 'blogetc');
    }

    /**
     * If full text search is not enabled in config, then disable syncing for the BlogEtcPost model.
     *
     * @return void
     */
    protected function disableFulltextSyncing(): void
    {
//        if (!config('blogetc.search.search_enabled')) {
//            // if search is disabled, don't allow it to sync full text.
//            ModelObserver::disableSyncingFor(Post::class);
//        }
    }

    /**
     * If config is set to include default routes, load the routes file.
     *
     * @return void
     */
    protected function includeRoutes(): void
    {
        if (config('blogetc.include_default_routes', true)) {
            include __DIR__.'/routes.php';
        }
    }

    /**
     * Setup the files for vendor:publish.
     *
     * @return void
     */
    protected function publishFiles(): void
    {
        $this->publishes([
            __DIR__.'/../migrations' => database_path('migrations'),
            __DIR__.'/Views/blogetc' => base_path('resources/views/vendor/blogetc'),
            __DIR__.'/Views/blogetc_admin' => base_path('resources/views/vendor/blogetc_admin'),
            __DIR__.'/Config/blogetc.php' => config_path('blogetc.php'),
            __DIR__.'/css/blogetc_admin_css.css' => public_path('blogetc_admin_css.css'),
        ]);
    }

    /**
     * Set up default gates.
     *
     * @see https://laravel.com/docs/5.8/authorization#authorizing-actions-via-gates
     */
    protected function setupDefaultGates(): void
    {
        // disable this function by adding undocumented config:
        if (config('blogetc.default-gates', true) === false) {
            return;
        }

        // You must add a gate with the ability name 'blog-etc-admin' to your AuthServiceProvider class.
        // This is provided only as a backup, which will restrict all access to BlogEtc admin.
        if (!Gate::has('blog-etc-admin')) {
            Gate::define('blog-etc-admin', static function ($user) {
                throw new LogicException('You must implement your own gate in AuthServiceProvider'.
                    ' for the "blog-etc-admin" gate.');
            });
        }

        if (!Gate::has('view-blog-etc-post')) {
            // Used for the search results
            Gate::define('view-blog-etc-post', static function (?Model $user, Post $post) {
                return $post->is_published && $post->posted_at->isPast();
            });
        }

        // Some defaults which allow everything through - you can override these and add your own logic.

        /*
         * For people to add comments to your blog posts.
         */
        if (!Gate::has('blog-etc-add-comment')) {
            Gate::define('blog-etc-add-comment', static function (?Model $user) {
                return true;
            });
        }

        /*
         * For an admin-like user to approve comments.
         */
        if (!Gate::has('blog-etc-approve-comments')) {
            Gate::define('blog-etc-approve-comments', static function ($user) {
                return true;
            });
        }
    }
}
