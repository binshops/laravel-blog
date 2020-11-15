<?php

namespace WebDevEtc\BlogEtc\Controllers;

use Illuminate\Http\Request;
use WebDevEtc\BlogEtc\Helpers;
use WebDevEtc\BlogEtc\Middleware\LoadLanguage;
use WebDevEtc\BlogEtc\Middleware\UserCanManageBlogPosts;
use WebDevEtc\BlogEtc\Models\HessamConfiguration;
use WebDevEtc\BlogEtc\Models\HessamLanguage;

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

    public function setup_submit(Request $request){
        if ($request['locale'] == null){
            return redirect( route('blogetc.admin.setup_submit') );
        }
        $language = new HessamLanguage();
        $language->active = $request['active'];
        $language->iso_code = $request['iso_code'];
        $language->locale = $request['locale'];
        $language->name = $request['name'];
        $language->date_format = $request['date_format'];

        $language->save();
        HessamConfiguration::set('INITIAL_SETUP', true);

        Helpers::flash_message("Language: " . $language->name . " has been added.");
        return redirect( route('blogetc.admin.index') );
    }
}
