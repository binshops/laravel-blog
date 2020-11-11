<?php

namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use WebDevEtc\BlogEtc\Events\CategoryAdded;
use WebDevEtc\BlogEtc\Events\CategoryEdited;
use WebDevEtc\BlogEtc\Events\CategoryWillBeDeleted;
use WebDevEtc\BlogEtc\Helpers;
use WebDevEtc\BlogEtc\Middleware\LoadLanguage;
use WebDevEtc\BlogEtc\Middleware\UserCanManageBlogPosts;
use WebDevEtc\BlogEtc\Models\HessamCategory;
use WebDevEtc\BlogEtc\Models\HessamCategoryTranslation;
use WebDevEtc\BlogEtc\Models\HessamLanguage;
use WebDevEtc\BlogEtc\Requests\DeleteBlogEtcCategoryRequest;
use WebDevEtc\BlogEtc\Requests\StoreBlogEtcCategoryRequest;
use WebDevEtc\BlogEtc\Requests\UpdateBlogEtcCategoryRequest;

/**
 * Class HessamCategoryAdminController
 * @package WebDevEtc\BlogEtc\Controllers
 */
class HessamCategoryAdminController extends Controller
{
    /**
     * HessamCategoryAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);

    }

    /**
     * Show list of categories
     *
     * @return mixed
     */
    public function index(Request $request){
        $language_id = $request->cookie('language_id');
        $categories = HessamCategoryTranslation::orderBy("category_id")->where('lang_id', $language_id)->paginate(25);
        return view("blogetc_admin::categories.index",[
            'categories' => $categories,
            'language_id' => $language_id
        ]);
    }

    /**
     * Show the form for creating new category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_category(Request $request){
        $language_id = $request->cookie('language_id');
        $language_list = HessamLanguage::where('active',true)->get();

        $cat_list = HessamCategory::whereHas('categoryTranslations', function ($query) {
            return $query->where('lang_id', '=', 1);
        })->get();

        $rootList = HessamCategory::roots()->get();
        HessamCategory::loadSiblingsWithList($rootList);


        return view("blogetc_admin::categories.add_category",[
            'category' => new \WebDevEtc\BlogEtc\Models\HessamCategory(),
            'category_translation' => new \WebDevEtc\BlogEtc\Models\HessamCategoryTranslation(),
            'category_tree' => $cat_list,
            'cat_roots' => $rootList,
            'language_id' => $language_id,
            'language_list' => $language_list
        ]);
    }

    /**
     * Store a new category
     *
     * @param StoreBlogEtcCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * This controller is totally REST controller
     */
    public function store_category(Request $request){
        $language_id = $request->cookie('language_id');
        $language_list = $request['data'];

        if ($request['parent_id']== 0){
            $request['parent_id'] = null;
        }
        $new_category = HessamCategory::create([
            'parent_id' => $request['parent_id']
        ]);

        foreach ($language_list as $key => $value) {
            if ($value['lang_id'] != -1){
                //check for slug availability
                $obj = HessamCategoryTranslation::where('slug',$value['slug'])->first();
                if ($obj){
                    HessamCategory::destroy($new_category->id);
                    return response()->json([
                        'code' => 403,
                        'message' => "slug is already taken",
                        'data' => $value['lang_id']
                    ]);
                }
                $new_category_translation = $new_category->categoryTranslations()->create([
                    'category_name' => $value['category_name'],
                    'slug' => $value['slug'],
                    'category_description' => $value['category_description'],
                    'lang_id' => $value['lang_id'],
                    'category_id' => $new_category->id
                ]);
            }
        }

        event(new CategoryAdded($new_category, $new_category_translation));
        Helpers::flash_message("Saved new category");
        return response()->json([
            'code' => 200,
            'message' => "category successfully aaded"
        ]);
    }

    /**
     * Show the edit form for category
     * @param $categoryId
     * @return mixed
     */
    public function edit_category($categoryId, Request $request){
        $language_id = $request->cookie('language_id');
        $language_list = HessamLanguage::where('active',true)->get();

        $category = HessamCategory::findOrFail($categoryId);
        $cat_trans = HessamCategoryTranslation::where(
            [
                ['lang_id', '=', $language_id],
                ['category_id', '=', $categoryId]
            ]
        )->first();

        return view("blogetc_admin::categories.edit_category",[
            'category' => $category,
            'category_translation' => $cat_trans,
            'categories_list' => HessamCategoryTranslation::orderBy("category_id")->where('lang_id', $language_id)->get(),
            'language_id' => $language_id,
            'language_list' => $language_list
        ]);
    }

    /**
     * Save submitted changes
     *
     * @param UpdateBlogEtcCategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_category(UpdateBlogEtcCategoryRequest $request, $categoryId){
        /** @var HessamCategory $category */
        $category = HessamCategory::findOrFail($categoryId);
        $language_id = $request->cookie('language_id');
        $translation = HessamCategoryTranslation::where(
            [
                ['lang_id', '=', $language_id],
                ['category_id', '=', $categoryId]
            ]
        )->first();
        $category->fill($request->all());
        $translation->fill($request->all());
        $category->save();
        $translation->save();

        Helpers::flash_message("Saved category changes");
        event(new CategoryEdited($category));
        return redirect($translation->edit_url());
    }

    /**
     * Delete the category
     *
     * @param DeleteBlogEtcCategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy_category(DeleteBlogEtcCategoryRequest $request, $categoryId){

        /* Please keep this in, so code inspectiwons don't say $request was unused. Of course it might now get marked as left/right parts are equal */
        $request=$request;

        $category = HessamCategory::findOrFail($categoryId);
        $children = $category->children()->get();
        if (sizeof($children) > 0) {
            Helpers::flash_message("This category could not be deleted it has some sub-categories. First try to change parent category of subs.");
            return redirect(route('blogetc.admin.categories.index'));
        }

        event(new CategoryWillBeDeleted($category));
        $category->delete();

        Helpers::flash_message("Category successfully deleted!");
        return redirect( route('blogetc.admin.categories.index') );
    }

}
