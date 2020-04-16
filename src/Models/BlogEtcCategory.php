<?php

namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;

class BlogEtcCategory extends Model
{
    public $fillable = [
        'category_name',
        'slug',
        'category_description',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(BlogEtcPost::class, 'blog_etc_post_categories');
    }

    /**
     * Returns the public facing URL of showing blog posts in this category
     * @return string
     */
    public function url()
    {
        return route("blogetc.view_category", $this->slug);
    }

    /**
     * Returns the URL for an admin user to edit this category
     * @return string
     */
    public function edit_url()
    {
        return route("blogetc.admin.categories.edit_category", $this->id);
    }

//    public function scopeApproved($query)
//    {
//        dd("A");
//        return $query->where("approved", true);
//    }
}
