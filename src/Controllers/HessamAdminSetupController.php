<?php

namespace WebDevEtc\BlogEtc\Controllers;

use Illuminate\Http\Request;
use WebDevEtc\BlogEtc\Middleware\LoadLanguage;
use WebDevEtc\BlogEtc\Middleware\UserCanManageBlogPosts;

/**
 * Class HessamAdminSetupController
 * Handles initial setup for Hessam CMS
*/
class HessamAdminSetupController
{
    /**
     * HessamAdminSetupController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);

        if (!is_array(config("blogetc"))) {
            throw new \RuntimeException('The config/blogetc.php does not exist. Publish the vendor files for the BlogEtc package by running the php artisan publish:vendor command');
        }
    }

    /**
     * View all posts
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view("blogetc_admin::setup.setup");
    }
}
