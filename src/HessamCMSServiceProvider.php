<?php

namespace HessamCMS;

use HessamCMS\Models\HessamPostTranslation;
use Illuminate\Support\ServiceProvider;
use HessamCMS\Models\HessamPost;
use HessamCMS\Laravel\Fulltext\Commands\Index;
use HessamCMS\Laravel\Fulltext\Commands\IndexOne;
use HessamCMS\Laravel\Fulltext\Commands\UnindexOne;
use HessamCMS\Laravel\Fulltext\ModelObserver;
use HessamCMS\Laravel\Fulltext\Search;
use HessamCMS\Laravel\Fulltext\SearchInterface;

class HessamCMSServiceProvider extends ServiceProvider
{

    protected $commands = [
        Index::class,
        IndexOne::class,
        UnindexOne::class,
    ];
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if (config("hessamcms.search.search_enabled") == false) {
            // if search is disabled, don't allow it to sync.
            ModelObserver::disableSyncingFor(HessamPostTranslation::class);
        }

        if (config("hessamcms.include_default_routes", true)) {
            include(__DIR__ . "/routes.php");
        }

        foreach ([
                     '2020_10_16_005400_create_hessam_categories_table.php',
                     '2020_10_16_005425_create_hessam_category_translations_table.php',
                     '2020_10_16_010039_create_hessam_posts_table.php',
                     '2020_10_16_010049_create_hessam_post_translations_table.php',
                     '2020_10_16_121230_create_hessam_comments_table.php',
                     '2020_10_16_121728_create_hessam_uploaded_photos_table.php',
                     '2020_10_16_004241_create_hessam_languages_table.php',
                     '2020_10_22_132005_create_hessam_configurations_table.php',
                     '2016_11_04_152913_create_laravel_fulltext_table.php'
                 ] as $file) {

            $this->publishes([
                __DIR__ . '/../migrations/' . $file => database_path('migrations/' . $file)
            ]);

        }

        $this->publishes([
            __DIR__ . '/Views/hessamcms' => base_path('resources/views/vendor/hessamcms'),
            __DIR__ . '/Config/hessamcms.php' => config_path('hessamcms.php'),
            __DIR__ . '/css/hessamcms_admin_css.css' => public_path('hessamcms_admin_css.css'),
            __DIR__ . '/css/hessam-blog.css' => public_path('hessam-blog.css'),
            __DIR__ . '/css/admin-setup.css' => public_path('admin-setup.css'),
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
        $this->app->bind(
            SearchInterface::class,
            Search::class
        );

        // for the admin backend views ( view("hessamcms_admin::BLADEFILE") )
        $this->loadViewsFrom(__DIR__ . "/Views/hessamcms_admin", 'hessamcms_admin');

        // for public facing views (view("hessamcms::BLADEFILE")):
        // if you do the vendor:publish, these will be copied to /resources/views/vendor/hessamcms anyway
        $this->loadViewsFrom(__DIR__ . "/Views/hessamcms", 'hessamcms');
    }

}
