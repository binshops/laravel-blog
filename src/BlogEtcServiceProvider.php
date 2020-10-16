<?php

namespace WebDevEtc\BlogEtc;

use Illuminate\Support\ServiceProvider;
use Swis\Laravel\Fulltext\ModelObserver;
use WebDevEtc\BlogEtc\Models\HessamPost;

class BlogEtcServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (config("blogetc.search.search_enabled") == false) {
            // if search is disabled, don't allow it to sync.
            ModelObserver::disableSyncingFor(HessamPost::class);
        }

        if (config("blogetc.include_default_routes", true)) {
            include(__DIR__ . "/routes.php");
        }


        foreach ([
                     '2020_10_16_005400_create_hessam_categories_table.php',
                     '2020_10_16_005425_create_hessam_category_translations_table.php',
                     '2020_10_16_010039_create_hessam_posts_table.php',
                     '2020_10_16_010049_create_hessam_post_translations_table.php',
                     '2020_10_16_121230_create_hessam_comments_table.php',
                     '2020_10_16_121728_create_hessam_uploaded_photos_table.php',
                     '2020_10_16_124241_create_hessam_languages_table.php'
                 ] as $file) {

            $this->publishes([
                __DIR__ . '/../migrations/' . $file => database_path('migrations/' . $file)
            ]);

        }

        $this->publishes([
            __DIR__ . '/Views/blogetc' => base_path('resources/views/vendor/blogetc'),
            __DIR__ . '/Config/blogetc.php' => config_path('blogetc.php'),
            __DIR__ . '/css/blogetc_admin_css.css' => public_path('blogetc_admin_css.css'),
            __DIR__ . '/css/hessam-blog.css' => public_path('hessam-blog.css'),
            __DIR__ . '/js/hessam-blog.js' => public_path('hessam-blog.js'),
        ]);


    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

        // for the admin backend views ( view("blogetc_admin::BLADEFILE") )
        $this->loadViewsFrom(__DIR__ . "/Views/blogetc_admin", 'blogetc_admin');

        // for public facing views (view("blogetc::BLADEFILE")):
        // if you do the vendor:publish, these will be copied to /resources/views/vendor/blogetc anyway
        $this->loadViewsFrom(__DIR__ . "/Views/blogetc", 'blogetc');
    }

}
