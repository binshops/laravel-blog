<?php

namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;
use WebDevEtc\BlogEtc\Scopes\BlogEtcPublishedScope;

/**
 * Class HessamPost
 * @package WebDevEtc\BlogEtc\Models
 */
class HessamPost extends Model
{
    /**
     * @var array
     */
    public $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * @var array
     */
    public $dates = [
        'posted_at'
    ];

    /**
     * @var array
     */
    public $fillable = [
        'is_published',
        'posted_at',
    ];

    /**
     * The associated post translations
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function postTranslations()
    {
        return $this->hasMany(HessamPostTranslation::class,"post_id");
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /* If user is logged in and \Auth::user()->canManageBlogEtcPosts() == true, show any/all posts.
           otherwise (which will be for most users) it should only show published posts that have a posted_at
           time <= Carbon::now(). This sets it up: */
        static::addGlobalScope(new BlogEtcPublishedScope());

        static::deleting(function($post) { // before delete() method call this
            $post->postTranslations()->delete();
        });
    }

    /**
     * The associated author (if user_id) is set
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(config("blogetc.user_model"), 'user_id');
    }

    /**
     * Return author string (either from the User (via ->user_id), or the submitted author_name value
     * @return string
     */
    public function author_string()
    {
        if ($this->author) {
            return optional($this->author)->name;
        } else {
            return 'Unknown Author';
        }
    }

    /**
     * The associated categories for this blog post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(HessamCategory::class, 'hessam_post_categories','post_id','category_id');
    }

    /**
     * Comments for this post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(HessamComment::class, 'post_id');
    }

}
