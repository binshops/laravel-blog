<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use BinshopsBlog\Events\CategoryAdded;
use BinshopsBlog\Events\CategoryEdited;
use BinshopsBlog\Events\CategoryWillBeDeleted;
use BinshopsBlog\Helpers;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use BinshopsBlog\Models\BinshopsBlogCategory;
use BinshopsBlog\Requests\DeleteBinshopsBlogCategoryRequest;
use BinshopsBlog\Requests\StoreBinshopsBlogCategoryRequest;
use BinshopsBlog\Requests\UpdateBinshopsBlogCategoryRequest;

/**
 * Class BinshopsBlogCategoryAdminController
 * @package BinshopsBlog\Controllers
 */
class BinshopsBlogCategoryAdminController extends Controller
{
    /**
     * BinshopsBlogCategoryAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
    }

    /**
     * Show list of categories
     *
     * @return mixed
     */
    public function index(){

        $categories = BinshopsBlogCategory::orderBy("category_name")->paginate(25);
        return view("binshopsblog_admin::categories.index")->withCategories($categories);
    }

    /**
     * Show the form for creating new category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_category(){

        return view("binshopsblog_admin::categories.add_category",[
            'category' => new \BinshopsBlog\Models\BinshopsBlogCategory(),
            'categories_list' => BinshopsBlogCategory::orderBy("category_name")->get()
        ]);

    }

    /**
     * Store a new category
     *
     * @param StoreBinshopsBlogCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store_category(StoreBinshopsBlogCategoryRequest $request){
        if ($request['parent_id']== 0){
            $request['parent_id'] = null;
        }
        $new_category = BinshopsBlogCategory::create($request->all());

        Helpers::flash_message("Saved new category");

        event(new CategoryAdded($new_category));
        return redirect( route('binshopsblog.admin.categories.index') );
    }

    /**
     * Show the edit form for category
     * @param $categoryId
     * @return mixed
     */
    public function edit_category($categoryId){
        $category = BinshopsBlogCategory::findOrFail($categoryId);
        return view("binshopsblog_admin::categories.edit_category",[
            'categories_list' => BinshopsBlogCategory::orderBy("category_name")->get()
        ])->withCategory($category);
    }

    /**
     * Save submitted changes
     *
     * @param UpdateBinshopsBlogCategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_category(UpdateBinshopsBlogCategoryRequest $request, $categoryId){
        /** @var BinshopsBlogCategory $category */
        $category = BinshopsBlogCategory::findOrFail($categoryId);
        $category->fill($request->all());
        $category->save();

        Helpers::flash_message("Saved category changes");
        event(new CategoryEdited($category));
        return redirect($category->edit_url());
    }

    /**
     * Delete the category
     *
     * @param DeleteBinshopsBlogCategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy_category(DeleteBinshopsBlogCategoryRequest $request, $categoryId){

        /* Please keep this in, so code inspections don't say $request was unused. Of course it might now get marked as left/right parts are equal */
        $request=$request;

        $category = BinshopsBlogCategory::findOrFail($categoryId);
        event(new CategoryWillBeDeleted($category));
        $category->delete();

        return view ("binshopsblog_admin::categories.deleted_category");

    }

}
