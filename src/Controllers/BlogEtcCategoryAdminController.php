<?php

namespace WebDevEtc\BlogEtc\Controllers;

use App\Http\Controllers\Controller;
use WebDevEtc\BlogEtc\Events\CategoryAdded;
use WebDevEtc\BlogEtc\Events\CategoryEdited;
use WebDevEtc\BlogEtc\Events\CategoryWillBeDeleted;
use WebDevEtc\BlogEtc\Helpers;
use WebDevEtc\BlogEtc\Middleware\UserCanManageBlogPosts;
use WebDevEtc\BlogEtc\Models\BlogEtcCategory;
use WebDevEtc\BlogEtc\Requests\DeleteBlogEtcCategoryRequest;
use WebDevEtc\BlogEtc\Requests\StoreBlogEtcCategoryRequest;
use WebDevEtc\BlogEtc\Requests\UpdateBlogEtcCategoryRequest;

/**
 * Class BlogEtcCategoryAdminController
 * @package WebDevEtc\BlogEtc\Controllers
 */
class BlogEtcCategoryAdminController extends Controller
{
    /**
     * BlogEtcCategoryAdminController constructor.
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

        $categories = BlogEtcCategory::orderBy("category_name")->paginate(25);
        return view("blogetc_admin::categories.index")->withCategories($categories);
    }

    /**
     * Show the form for creating new category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_category(){

        return view("blogetc_admin::categories.add_category");

    }

    /**
     * Store a new category
     *
     * @param StoreBlogEtcCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store_category(StoreBlogEtcCategoryRequest $request){
        $new_category = new BlogEtcCategory($request->all());
        $new_category->save();

        Helpers::flash_message("Saved new category");

        event(new CategoryAdded($new_category));
        return redirect( route('blogetc.admin.categories.index') );
    }

    /**
     * Show the edit form for category
     * @param $categoryId
     * @return mixed
     */
    public function edit_category($categoryId){
        $category = BlogEtcCategory::findOrFail($categoryId);
        return view("blogetc_admin::categories.edit_category")->withCategory($category);
    }

    /**
     * Save submitted changes
     *
     * @param UpdateBlogEtcCategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_category(UpdateBlogEtcCategoryRequest $request, $categoryId){
        /** @var BlogEtcCategory $category */
        $category = BlogEtcCategory::findOrFail($categoryId);
        $category->fill($request->all());
        $category->save();

        Helpers::flash_message("Saved category changes");
        event(new CategoryEdited($category));
        return redirect($category->edit_url());
    }

    /**
     * Delete the category
     *
     * @param DeleteBlogEtcCategoryRequest $request
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy_category(DeleteBlogEtcCategoryRequest $request, $categoryId){

        /* Please keep this in, so code inspections don't say $request was unused. Of course it might now get marked as left/right parts are equal */
        $request=$request;

        $category = BlogEtcCategory::findOrFail($categoryId);
        event(new CategoryWillBeDeleted($category));
        $category->delete();

        return view ("blogetc_admin::categories.deleted_category");

    }

}
