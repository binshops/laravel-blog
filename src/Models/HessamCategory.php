<?php

namespace WebDevEtc\BlogEtc\Models;

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
        return $this->belongsToMany(HessamPost::class, 'hessam_post_categories','category_id', 'post_id');
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
