<?php

namespace WebDevEtc\BlogEtc\Models;

use App\User;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;
use InvalidArgumentException;
use RuntimeException;
use Swis\LaravelFulltext\Indexable;
use Throwable;
use WebDevEtc\BlogEtc\Exceptions\InvalidImageSizeException;
use WebDevEtc\BlogEtc\Scopes\PostPublishedScope;
use WebDevEtc\BlogEtc\Services\UploadsService;

/**
 * Class BlogEtcPost.
 *
 * @property string|null title
 * @property string|null subtitle
 * @property string|null short_description
 * @property string|null post_body
 * @property string|null seo_title
 * @property string|null meta_desc
 * @property string|null slug
 * @property string|null use_view_file
 * @property Carbon posted_at
 * @property bool is_published
 * @property User|null author
 * @property Category[] categories
 * @property int id
 * @property Collection|Comment[] comments
 */
class Post extends Model
{
    use Sluggable;
    // todo: add indexable again.
    // use Indexable;

    /**
     * The callback or user property to be used when resolving author name.
     *
     * @var string|callable
     */
    protected static $authorNameResolver;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'blog_etc_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $casts = [
        'is_published' => 'boolean',
    ];

    /** @var array */
    public $dates = [
        'posted_at',
    ];

    /** @var array */
    public $fillable = [
        'title',
        'subtitle',
        'short_description',
        'post_body',
        'seo_title',
        'meta_desc',
        'slug',
        'use_view_file',
        'is_published',
        'posted_at',
    ];

    // index content columns, used for full text search:
    protected $indexContentColumns =
        [
            'post_body',
            'short_description',
            'meta_desc',
        ];

    // index title columns, used for full text search:
    protected $indexTitleColumns =
        [
            'title',
            'subtitle',
            'seo_title',
        ];

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::$authorNameResolver = config('blogetc.comments.user_field_for_author_name');

        // by default users without correct permission will only see published posts. Admin-like users will see
        // any posts. Defined in a gate. See docs for details.
        static::addGlobalScope(new PostPublishedScope());
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    /**
     * The associated author (if user_id) is set.
     *
     * @return BelongsTo
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(config('blogetc.user_model'), 'user_id');
    }

    /**
     * Return author string (either from the User (via ->user_id), or the submitted author_name value.
     *
     * @return string
     */
    public function authorString(): ?string
    {
        if ($this->author) {
            return is_callable(self::$authorNameResolver)
                ? call_user_func(self::$authorNameResolver, $this->author)
                : $this->author->{self::$authorNameResolver};
        }

        return 'Unknown Author';
    }

    /**
     * The associated categories relationship for this blog post.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            Category::class,
            'blog_etc_post_categories',
            'blog_etc_post_id',
            'blog_etc_category_id'
        );
    }

    /**
     * Comments relationship for this post.
     *
     * @return HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'blog_etc_post_id');
    }

    /**
     * Return the URL for editing the post (used for admin users).
     *
     * @return string
     */
    public function editUrl(): string
    {
        return route('blogetc.admin.edit_post', $this->id);
    }

    /**
     * @throws Exception
     *
     * @return string
     */
    public function fullViewFilePath(): string
    {
        return resource_path('views/custom_blog_posts/'.$this->use_view_file.'.blade.php');
    }

    /**
     * If $this->user_view_file is not empty, then it'll return the dot syntax
     * location of the blade file it should look for.
     *
     * @throws Exception
     *
     * @return string
     */
    public function bladeViewFile(): string
    {
        if (!$this->use_view_file) {
            throw new RuntimeException('use_view_file was empty, so cannot use fullViewFilePath()');
        }

        return 'custom_blog_posts.'.$this->use_view_file;
    }

    /**
     * Generate a full <img src='' alt=''> img tag.
     *
     * @param string      $size           - large, medium, thumbnail
     * @param bool        $addAHref       - if true then it will add <a href=''>...</a> around the <img> tag
     * @param null|string $imgTagClass    - if you want any additional CSS classes for this tag for the <IMG>
     * @param null|string $anchorTagClass - is you want any additional CSS classes in the <a> anchor tag
     *
     * @return HtmlString
     */
    public function imageTag(
        $size = 'medium',
        $addAHref = true,
        $imgTagClass = null,
        $anchorTagClass = null
    ): HtmlString {
        if (!$this->hasImage($size)) {
            // return an empty string if this image does not exist.
            return new HtmlString('');
        }
        $imageUrl = e($this->imageUrl($size));
        $imageAltText = e($this->title);
        $imgTag = '<img src="'.$imageUrl.'" alt="'.$imageAltText.'" class="'.e($imgTagClass).'">';

        return new HtmlString(
            $addAHref
                ? '<a class="'.e($anchorTagClass).'" href="'.e($this->url()).'">'.$imgTag.'</a>'
                : $imgTag
        );
    }

    /**
     * Returns true if the database record indicates that this blog post
     * has a featured image of size $size.
     *
     * @param string $size
     *
     * @return bool
     */
    public function hasImage($size = 'medium'): bool
    {
        $this->checkValidImageSize($size);

        return array_key_exists('image_'.$size, $this->getAttributes()) && $this->{'image_'.$size};
    }

    /**
     * Throws an exception if $size is not valid
     * It should be either 'large','medium','thumbnail'.
     *
     * @param string $size
     *
     * @throws InvalidArgumentException
     *
     * @return bool
     */
    protected function checkValidImageSize(string $size = 'medium'): bool
    {
        if (array_key_exists('image_'.$size, config('blogetc.image_sizes', []))) {
            // correct size string - just return
            return true;
        }

        // if it got this far then the size was not valid. As this error will probably be seen by whoever set up the
        // blog, return a useful message to help with debugging.

        if (Str::startsWith($size, 'image_')) {
            // $size starts with image_, which is an error
            /* the config/blogetc.php and the DB columns SHOULD have keys that start with image_$size
            however when using methods such as image_url() or has_image() it SHOULD NOT start with 'image_'

            To put another way: :
                in the config/blogetc.php : config("blogetc.image_sizes.image_medium")
                in the database table:    : blogetc_posts.image_medium
                when calling image_url()  : image_url("medium")
            */
            throw new InvalidImageSizeException(
                'Invalid image size ('.e($size).'). BlogEtcPost image size should not begin with'.
                ' \'image_\'. Remove this from the start of '.e($size).'. It *should* be in the'.
                ' blogetc.image_sizes config though'
            );
        }

        throw new InvalidImageSizeException(
            'BlogEtcPost image size should be \'large\', \'medium\', \'thumbnail\''.
            ' or another field as defined in config/blogetc.php. Provided size ('.e($size).') is not valid'
        );
    }

    /**
     * Get the full URL for an image
     * You should use ::has_image($size) to check if the size is valid.
     *
     * @param string $size - should be 'medium' , 'large' or 'thumbnail'
     *
     * @return string
     */
    public function imageUrl($size = 'medium'): string
    {
        $this->checkValidImageSize($size);
        $filename = $this->{'image_'.$size};

        return UploadsService::publicUrl($filename);
    }

    /**
     * Returns the public facing URL to view this blog post.
     *
     * @return string
     */
    public function url(): string
    {
        return route('blogetc.show', $this->slug);
    }

    /**
     * Generate an introduction, max length $max_len characters.
     *
     * @param int $maxLen
     *
     * @return string
     */
    public function generateIntroduction(int $maxLen = 500): string
    {
        $base_text_to_use = $this->short_description;

        if (!trim($base_text_to_use)) {
            $base_text_to_use = $this->post_body;
        }
        $base_text_to_use = strip_tags($base_text_to_use);

        return Str::limit($base_text_to_use, $maxLen);
    }

    /**
     * Return post body HTML, ready for output.
     *
     * @throws Throwable
     *
     * @return HtmlString
     */
    public function renderBody(): HtmlString
    {
        $body = $this->use_view_file && config('blogetc.use_custom_view_files')
            ? view('blogetc::partials.use_view_file', ['post' => $this])->render()
            : $this->post_body;

        if (!config('blogetc.echo_html')) {
            // if this is not true, then we should escape the output
            if (config('blogetc.strip_html')) {
                // not perfect, but it will get wrapped in htmlspecialchars in e() anyway
                $body = strip_tags($body);
            }

            $body = e($body);

            if (config('blogetc.auto_nl2br')) {
                $body = nl2br($body);
            }
        }

        return new HtmlString($body);
    }

    /**
     * If $this->seo_title was set, return that.
     * Otherwise just return $this->title.
     *
     * Basically return $this->seo_title ?? $this->title;
     *
     * TODO - what convention do we use for gen/generate/etc for naming of this.
     *
     * @return string
     */
    public function genSeoTitle(): ?string
    {
        if ($this->seo_title) {
            return $this->seo_title;
        }

        return $this->title;
    }

    /**
     * @return string|null
     *
     * @deprecated - use genSeoTitle() instead
     */
    public function gen_seo_title(): ?string
    {
        return $this->genSeoTitle();
    }

    /**
     * @param mixed ...$args
     *
     * @return HtmlString
     *
     * @deprecated - use imageTag() instead, which returns a HtmlString
     */
    public function image_tag(...$args): HtmlString
    {
        return $this->imageTag(...$args);
    }

    /**
     * @param string $size
     *
     * @return bool
     *
     * @deprecated  - use hasImage() instead
     */
    public function has_image($size = 'medium'): bool
    {
        return $this->hasImage($size);
    }

    /**
     * @return string|null
     *
     * @deprecated - use authorString() instead
     */
    public function author_string(): ?string
    {
        return $this->authorString();
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

    /**
     * @param string $size
     *
     * @return bool
     *
     * @deprecated - use checkValidImageSize()
     */
    protected function check_valid_image_size(string $size = 'medium'): bool
    {
        return $this->checkValidImageSize($size);
    }

    /**
     * @throws Exception
     *
     * @return string
     *
     * @deprecated - use bladeViewFile() instead
     */
    public function full_view_file_path(): string
    {
        return $this->bladeViewFile();
    }

    /**
     * @param string $size
     *
     * @return string
     *
     * @deprecated - use imageUrl() instead
     */
    public function image_url($size = 'medium'): string
    {
        return $this->imageUrl($size);
    }

    /**
     * @param int $maxLen
     *
     * @return string
     *
     * @deprecated - use generateIntroduction() instead
     */
    public function generate_introduction(int $maxLen = 500): string
    {
        return $this->generateIntroduction($maxLen);
    }

    /**
     * @throws Throwable
     *
     * @return string
     *
     * @deprecated - use renderBody() instead
     *
     * (post_body_output used to return a string, renderBody() now returns HtmlString)
     */
    public function post_body_output(): string
    {
        return $this->renderBody();
    }
}
