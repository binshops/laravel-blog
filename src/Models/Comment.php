<?php

namespace WebDevEtc\BlogEtc\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use WebDevEtc\BlogEtc\Scopes\BlogCommentApprovedAndDefaultOrderScope;

/**
 * @property string author_name
 * @property int user_id
 * @property string|null author_website
 * @property string|null ip
 * @property string|null author_email
 * @property bool approved
 * @property Post post
 * @property User user
 * @property string author
 */
class Comment extends Model
{
    /**
     * Attributes which have specific casts.
     *
     * @var array
     */
    public $casts = [
        'approved' => 'boolean',
    ];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'blog_etc_comments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'comment',
        'author_name',
    ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        /* If user is logged in and \Auth::user()->canManageBlogEtcPosts() == true, show any/all posts.
           otherwise (which will be for most users) it should only show published posts that have a posted_at
           time <= Carbon::now(). This sets it up: */
        static::addGlobalScope(new BlogCommentApprovedAndDefaultOrderScope());
    }

    /**
     * The BlogEtcPost relationship.
     *
     * @return BelongsTo
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'blog_etc_post_id');
    }

    /**
     * Comment author relationship.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(config('blogetc.user_model'));
    }

    /**
     * Return author string (either from the User (via ->user_id), or the submitted author_name value.
     *
     * TODO - rename this as it looks like a relationship
     *
     * @return string|null
     */
    public function author(): ?string
    {
        if ($this->user_id) {
            // a user is associated with this
            $field = config('blogetc.comments.user_field_for_author_name', 'name');

            return optional($this->user)->$field;
        }

        // otherwise return the string value of 'author_name' which guests can submit:
        return $this->author_name;
    }
}
