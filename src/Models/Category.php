<?php

namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string category_name
 * @property string slug
 * @property int id
 * @property Collection|Post[] posts
 *
 * @method static findOrFail(int $categoryID)
 */
class Category extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'blog_etc_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        // todo - change to just name
        'category_name',
        'slug',
        // todo - change to just description
        'category_description',
    ];

    /**
     * BlogEtcPost relationship.
     *
     * @return BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            Post::class,
            'blog_etc_post_categories',
            'blog_etc_category_id',
            'blog_etc_post_id'
        );
    }

    /**
     * Returns the public facing URL of showing blog posts in this category.
     *
     * @return string
     */
    public function url(): string
    {
        return route('blogetc.view_category', $this->slug);
    }

    /**
     * Returns the URL for an admin user to edit this category.
     *
     * @return string
     */
    public function editUrl(): string
    {
        return route('blogetc.admin.categories.edit_category', $this->id);
    }

    /**
     * @return string
     *
     * @deprecated - use editUrl() instead
     */
    public function edit_url(): string
    {
        return $this->editUrl();
    }
}
