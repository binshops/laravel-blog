<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use BinshopsBlog\Helpers;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use BinshopsBlog\Models\BinshopsConfiguration;
use BinshopsBlog\Models\BinshopsLanguage;

/**
 * Class BinshopsAdminSetupController
 * Handles initial setup for Binshops Blog
 */
class BinshopsAdminSetupController extends Controller
{
    /**
     * BinshopsAdminSetupController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);

        if (!is_array(config("binshopsblog"))) {
            throw new \RuntimeException('The config/binshopsblog.php does not exist. Publish the vendor files for the BinshopsBlog package by running the php artisan publish:vendor command');
        }
    }

    /**
     * View all posts
     *
     * @return mixed
     */
    public function setup(Request $request)
    {
        return view("binshopsblog_admin::setup.setup");
    }

    public function setup_submit(Request $request){
        if ($request['locale'] == null){
            return redirect( route('binshopsblog.admin.setup_submit') );
        }
        $language = new BinshopsLanguage();
        $language->active = $request['active'];
        $language->iso_code = $request['iso_code'];
        $language->locale = $request['locale'];
        $language->name = $request['name'];
        $language->date_format = $request['date_format'];

        $language->save();
        if (!BinshopsConfiguration::get('INITIAL_SETUP')){
            BinshopsConfiguration::set('INITIAL_SETUP', true);
            BinshopsConfiguration::set('DEFAULT_LANGUAGE_LOCALE', $request['locale']);
        }

        return redirect( route('binshopsblog.admin.index') );
    }
}
