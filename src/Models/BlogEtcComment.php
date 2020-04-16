<?php

namespace WebDevEtc\BlogEtc\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use WebDevEtc\BlogEtc\Scopes\BlogCommentApprovedAndDefaultOrderScope;

class BlogEtcComment extends Model
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

        /* If user is logged in and \Auth::user()->canManageBlogEtcPosts() == true, show any/all posts.
           otherwise (which will be for most users) it should only show published posts that have a posted_at
           time <= Carbon::now(). This sets it up: */
        static::addGlobalScope(new BlogCommentApprovedAndDefaultOrderScope());
    }



    /**
     * The associated BlogEtcPost
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(BlogEtcPost::class,"blog_etc_post_id");
    }

    /**
     * Comment author user (if set)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return author string (either from the User (via ->user_id), or the submitted author_name value
     *
     * @return string
     */
    public function author()
    {
        if ($this->user_id) {
            $field = config("blogetc.comments.user_field_for_author_name","name");
            return optional($this->user)->$field;
        }

        return $this->author_name;
    }
}
