<?php

namespace BinshopsBlog\Controllers;

use App\Http\Controllers\Controller;
use BinshopsBlog\Events\FieldyAdded;
use Illuminate\Http\Request;
use BinshopsBlog\Events\FieldAdded;
use BinshopsBlog\Events\FieldWillBeDeleted;
use BinshopsBlog\Helpers;
use BinshopsBlog\Middleware\LoadLanguage;
use BinshopsBlog\Middleware\UserCanManageBlogPosts;
use BinshopsBlog\Models\BinshopsCategoryTranslation;
use BinshopsBlog\Models\BinshopsField;
use BinshopsBlog\Requests\BaseBinshopsFieldRequest;

/**
 * Class BinshopsFielddminController
 * @package BinshopsBlog\Controllers
 */
class BinshopsFieldAdminController extends Controller
{
    /**
     * BinshopsCategoryAdminController constructor.
     */
    public function __construct()
    {
        $this->middleware(UserCanManageBlogPosts::class);
        $this->middleware(LoadLanguage::class);
    }

    /**
     * Show list of fields
     *
     * @return mixed
     */
    public function index(Request $request)
    {
        $language_id = $request->get('language_id');
        $fields = BinshopsField::orderBy("label")->paginate(25);
        return view("binshopsblog_admin::fields.index", [
            'fields' => $fields,
            'language_id' => $language_id
        ]);
    }

    /**
     * Show the form for creating new field
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create_field(Request $request)
    {
        $language_id = $request->get('language_id');
        $categoriesTrans = BinshopsCategoryTranslation::where("lang_id", $language_id)->limit(1000)->get();

        return view("binshopsblog_admin::fields.form", [
            'field' => new \BinshopsBlog\Models\BinshopsField(),
            'categoriesTrans' => $categoriesTrans
        ]);
    }

    /**
     * Show the edit form for field
     * @param $fieldId
     * @return mixed
     */
    public function edit_field($fieldId, Request $request)
    {
        $language_id = $request->get('language_id');
        $categoriesTrans = BinshopsCategoryTranslation::where("lang_id", $language_id)->limit(1000)->get();

        $field = BinshopsField::where(
            [
                ['id', '=', $fieldId]
            ]
        )->first();

        return view("binshopsblog_admin::fields.form", [
            'field' => $field,
            'categoriesTrans' => $categoriesTrans
        ]);
    }

    /**
     * Store a new field
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     *
     * This controller is totally REST controller
     */
    public function store_field(BaseBinshopsFieldRequest $request)
    {
        $new_field = BinshopsField::updateOrCreate(
            ['id' => $request->post('id')],
            [
                'name' => $request->post('name'),
                'label' => $request->post('label'),
                'help' => $request->post('help'),
                'type' => $request->post('type'),
                'validation' => $request->post('validation')
            ]);

        $new_field->categories()->sync($request->categories());
        event(new FieldAdded($new_field));
        Helpers::flash_message("Saved new field");

        return redirect( route('binshopsblog.admin.fields.index') );
    }

    /**
     * Delete the field
     *
     * @param $request
     * @param $categoryId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function destroy_field($fieldId)
    {
        $field = BinshopsField::findOrFail($fieldId);

        if ($field->values()->exists()) {
            Helpers::flash_message("This field could not be deleted, blog posts with values for this field exists.");
            return redirect(route('binshopsblog.admin.fields.index'));
        }
        $field->categories()->detach();

        event(new FieldWillBeDeleted($field));
        $field->delete();

        Helpers::flash_message("Field successfully deleted!");
        return redirect(route('binshopsblog.admin.fields.index'));
    }
}
