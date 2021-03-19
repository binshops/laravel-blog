<?php


namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use BinshopsBlog\Models\BinshopsConfiguration;
use Illuminate\Http\Request;
use BinshopsBlog\Helpers;
use BinshopsBlog\Middleware\LoadLanguage;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use BinshopsBlog\Models\BinshopsLanguage;

class BinshopsLanguageAdminController extends Controller
{
    /**
     * BinshopsLanguageAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);

    }

    public function index(){
        $language_list = BinshopsLanguage::all();
        return view("binshopsblog_admin::languages.index",[
            'language_list' => $language_list
        ]);
    }

    public function create_language(){
        return view("binshopsblog_admin::languages.add_language");
    }

    public function store_language(Request $request){
        if ($request['locale'] == null){
            Helpers::flash_message("Select a language!");
            return view("binshopsblog_admin::languages.add_language");
        }
        $language = new BinshopsLanguage();
        $language->active = $request['active'];
        $language->iso_code = $request['iso_code'];
        $language->locale = $request['locale'];
        $language->name = $request['name'];
        $language->date_format = $request['date_format'];
        $language->rtl = $request['rtl'];

        $language->save();

        Helpers::flash_message("Language: " . $language->name . " has been added.");
        return redirect( route('binshopsblog.admin.languages.index') );
    }

    public function destroy_language(Request $request, $languageId){
        $lang = BinshopsLanguage::where('locale', BinshopsConfiguration::get('DEFAULT_LANGUAGE_LOCALE'))->first();
        if ($languageId == $lang->id){
            Helpers::flash_message("The default language can not be deleted!");
            return redirect( route('binshopsblog.admin.languages.index') );
        }

        try {
            $language = BinshopsLanguage::findOrFail($languageId);
            //todo
//        event(new CategoryWillBeDeleted($category));
            $language->delete();
            Helpers::flash_message("The language is successfully deleted!");
            return redirect( route('binshopsblog.admin.languages.index') );
        } catch (\Illuminate\Database\QueryException $e) {
            Helpers::flash_message("You can not delete this language, because it's used in posts or categoies.");
            return redirect( route('binshopsblog.admin.languages.index') );
        }
    }

    public function toggle_language(Request $request, $languageId){
        $language = BinshopsLanguage::findOrFail($languageId);
        if ($language->active == 1){
            $language->active = 0;
        }else if ($language->active == 0){
            $language->active = 1;
        }

        $language->save();
        //todo
        //event

        Helpers::flash_message("Language: " . $language->name . " has been disabled.");
        return redirect( route('binshopsblog.admin.languages.index') );
    }
}
