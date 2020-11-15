<?php

namespace HessamCMS\Controllers;

use Illuminate\Http\Request;
use HessamCMS\Helpers;
use HessamCMS\Middleware\LoadLanguage;
use HessamCMS\Middleware\UserCanManageBlogPosts;
use HessamCMS\Models\HessamConfiguration;
use HessamCMS\Models\HessamLanguage;

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

        if (!is_array(config("hessamcms"))) {
            throw new \RuntimeException('The config/hessamcms.php does not exist. Publish the vendor files for the HessamCMS package by running the php artisan publish:vendor command');
        }
    }

    /**
     * View all posts
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        return view("hessamcms_admin::setup.setup");
    }

    public function setup_submit(Request $request){
        if ($request['locale'] == null){
            return redirect( route('hessamcms.admin.setup_submit') );
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
        return redirect( route('hessamcms.admin.index') );
    }
}
