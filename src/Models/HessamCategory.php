<?php

namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;
use WebDevEtc\BlogEtc\Baum\Node;

class HessamCategory extends Node
{
    protected $parentColumn = 'parent_id';
    public $siblings = array();

    public $fillable = [
        'parent_id'
    ];

    /**
     * The associated category translations
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function categoryTranslations()
    {
        return $this->hasMany(HessamCategoryTranslation::class,"category_id");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(HessamPost::class, 'hessam_post_categories');
    }

    /**
     * Returns the public facing URL of showing blog posts in this category
     * @return string
     */
    public function url($language_id)
    {
        $theChainString = "";
        $chain = $this->getAncestorsAndSelf();
        foreach ($chain as $category){
            $theChainString .=  "/" . $category->categoryTranslations()->where('lang_id', $language_id)->first()->slug;
        }
        return route("blogetc.view_category", $theChainString);
    }

    /**
     * Returns the URL for an admin user to edit this category
     * @return string
     */
    public function edit_url()
    {
        return route("blogetc.admin.categories.edit_category", $this->id);
    }

    public function loadSiblings(){
        $this->siblings = $this->children()->get();
    }

//    public function parent()
//    {
//        return $this->belongsTo('WebDevEtc\BlogEtc\Models\HessamCategory', 'parent_id');
//    }
//
//    public function children()
//    {
//        return $this->hasMany('WebDevEtc\BlogEtc\Models\HessamCategory', 'parent_id');
//    }
//
//    // recursive, loads all descendants
//    private function childrenRecursive()
//    {
//        return $this->children()->with('children')->get();
//    }
//
//    public function loadChildren(){
//        $this->childrenCat = $this->childrenRecursive();
//    }

//    public function scopeApproved($query)
//    {
//        dd("A");
//        return $query->where("approved", true);
//    }
}
