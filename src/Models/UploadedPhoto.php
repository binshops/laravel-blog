<?php

namespace WebDevEtc\BlogEtc\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class BlogEtcUploadedPhoto.
 *
 * @property Post blogPost
 * @property User uploader
 * @property int|null blog_etc_post_id
 * @property string image_title
 * @property ing|null uploader_id
 * @property string source - see const values in this model
 * @property uploaded_images
 */
class UploadedPhoto extends Model
{
    /**
     * Source from a image uploaded not linked to a blog post.
     *
     * @var string
     */
    public const SOURCE_IMAGE_UPLOAD = 'ImageUpload';

    /**
     * Source from an image uploaded linked to a featured blog image.
     *
     * @var string
     */
    public const SOURCE_FEATURED_IMAGE = 'BlogFeaturedImage';

    /**
     * DB table name.
     *
     * @var string
     */
    public $table = 'blog_etc_uploaded_photos';

    /**
     * Eloquent cast attributes.
     *
     * @var array
     */
    public $casts = [
        'uploaded_images' => 'array',
    ];

    /**
     * Fillable attributes.
     *
     * @var array
     */
    public $fillable = [
        'blog_etc_post_id',
        'image_title',
        'uploader_id',
        'source',
        'uploaded_images',
    ];

    /**
     * Relationship for the user.
     *
     * @return BelongsTo
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(config('blogetc.user_model'), 'uploader_id');
    }

    /**
     * Relationship for a blog post for which this image is a featured image.
     *
     * @return BelongsTo
     */
    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
