<?php


namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use WebDevEtc\BlogEtc\Middleware\UserCanManageBlogPosts;

class HessamLanguageAdminController extends Controller
{
    /**
     * HessamLanguageAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
    }

    //todo
    public function index(){

    }

    public function create_language(){
        return view("blogetc_admin::languages.add_language");
    }

    //todo
    public function store_language(){
    }

    //todo
    public function edit_language(){

    }

    //todo:
    public function update_language(){

    }

    //todo
    public function destroy_language(){

    }
}
