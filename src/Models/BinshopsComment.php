<?php

namespace BinshopsBlog\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use BinshopsBlog\Scopes\BlogCommentApprovedAndDefaultOrderScope;

class BinshopsComment extends Model
{
    public $casts = [
        'approved' => 'boolean',
    ];

    public $fillable = [

        'comment',
        'author_name',
    ];


    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /* If user is logged in and \Auth::user()->canManageBinshopsBlogPosts() == true, show any/all posts.
           otherwise (which will be for most users) it should only show published posts that have a posted_at
           time <= Carbon::now(). This sets it up: */
        static::addGlobalScope(new BlogCommentApprovedAndDefaultOrderScope());
    }



    /**
     * The associated BinshopsPost
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(BinshopsPost::class,"post_id");
    }

    /**
     * Comment author user (if set)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(config("binshopsblog.user_model"), 'user_id');
    }

    /**
     * Return author string (either from the User (via ->user_id), or the submitted author_name value
     *
     * @return string
     */
    public function author()
    {
        if ($this->user_id) {
            $field = config("binshopsblog.comments.user_field_for_author_name","name");
            return optional($this->user)->$field;
        }

        return $this->author_name;
    }
}
