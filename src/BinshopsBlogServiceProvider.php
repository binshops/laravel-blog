<?php

namespace BinshopsBlog;

use Illuminate\Support\ServiceProvider;
use Swis\Laravel\Fulltext\ModelObserver;
use BinshopsBlog\Models\BinshopsBlogPost;

class BinshopsBlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (config("binshopsblog.search.search_enabled") == false) {
            // if search is disabled, don't allow it to sync.
            ModelObserver::disableSyncingFor(BinshopsBlogPost::class);
        }

        if (config("binshopsblog.include_default_routes", true)) {
            include(__DIR__ . "/routes.php");
        }


        foreach ([
                     '2018_05_28_224023_create_binshops_blog_posts_table.php',
                     '2018_09_16_224023_add_author_and_url_binshops_blog_posts_table.php',
                     '2018_09_26_085711_add_short_desc_textrea_to_binshops_blog.php',
                     '2018_09_27_122627_create_binshops_blog_uploaded_photos_table.php',
                     '2020_05_27_104123_add_parameters_binshops_blog_categories_table.php'
                 ] as $file) {

            $this->publishes([
                __DIR__ . '/../migrations/' . $file => database_path('migrations/' . $file)
            ]);

        }

        $this->publishes([
            __DIR__ . '/Views/binshopsblog' => base_path('resources/views/vendor/binshopsblog'),
            __DIR__ . '/Config/binshopsblog.php' => config_path('binshopsblog.php'),
            __DIR__ . '/css/binshopsblog_admin.css' => public_path('binshopsblog_admin.css'),
            __DIR__ . '/css/binshops-blog.css' => public_path('binshops-blog.css'),
            __DIR__ . '/js/binshops-blog.js' => public_path('binshops-blog.js'),
        ]);


    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        // for the admin backend views ( view("binshopsblog_admin::BLADEFILE") )
        $this->loadViewsFrom(__DIR__ . "/Views/binshopsblog_admin", 'binshopsblog_admin');

        // for public facing views (view("binshopsblog::BLADEFILE")):
        // if you do the vendor:publish, these will be copied to /resources/views/vendor/binshopsblog anyway
        $this->loadViewsFrom(__DIR__ . "/Views/binshopsblog", 'binshopsblog');
    }

}
