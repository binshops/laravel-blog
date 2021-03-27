<?php

namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;
use BinshopsBlog\Baum\Node;

class BinshopsBlogCategory extends Node
{
    protected $parentColumn = 'parent_id';
    public $siblings = array();

    public $fillable = [
        'category_name',
        'slug',
        'category_description',
        'parent_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(BinshopsBlogPost::class, 'binshops_blog_post_categories');
    }

    /**
     * Returns the public facing URL of showing blog posts in this category
     * @return string
     */
    public function url()
    {
        $theChainString = "";
        $chain = $this->getAncestorsAndSelf();
        foreach ($chain as $category){
            $theChainString .=  "/" . $category->slug;
        }
        return route("binshopsblog.view_category", $theChainString);
    }

    /**
     * Returns the URL for an admin user to edit this category
     * @return string
     */
    public function edit_url()
    {
        return route("binshopsblog.admin.categories.edit_category", $this->id);
    }

    public function loadSiblings(){
        $this->siblings = $this->children()->get();
    }

//    public function parent()
//    {
//        return $this->belongsTo('BinshopsBlog\Models\BinshopsBlogCategory', 'parent_id');
//    }
//
//    public function children()
//    {
//        return $this->hasMany('BinshopsBlog\Models\BinshopsBlogCategory', 'parent_id');
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
