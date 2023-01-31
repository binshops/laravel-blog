<?php

namespace BinshopsBlog\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use BinshopsBlog\Laravel\Fulltext\Indexable;
use Illuminate\Database\Eloquent\Model;
use BinshopsBlog\Interfaces\SearchResultInterface;

class BinshopsPostTranslation extends Model implements SearchResultInterface
{
    use Sluggable;
    use Indexable;

    protected $indexContentColumns = ['post_body', 'short_description', 'meta_desc',];
    protected $indexTitleColumns = ['title', 'subtitle', 'seo_title',];

    public $fillable = [
        'title',
        'subtitle',
        'short_description',
        'post_body',
        'seo_title',
        'meta_desc',
        'slug',
        'use_view_file',
    ];

    /**
     * Get the user that owns the phone.
     */
    public function post()
    {
        return $this->belongsTo(BinshopsPost::class, 'post_id');
    }

    /**
     * The associated Language
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language()
    {
        return $this->hasOne(BinshopsLanguage::class,"lang_id");
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
                'source' => 'title'
            ]
        ];
    }

    public function search_result_page_url()
    {
        return $this->url();
    }

    public function search_result_page_title()
    {
        return $this->title;
    }

    /**
     * If $this->user_view_file is not empty, then it'll return the dot syntax location of the blade file it should look for
     * @return string
     * @throws \Exception
     */
    public function full_view_file_path()
    {
        if (!$this->use_view_file) {
            throw new \RuntimeException("use_view_file was empty, so cannot use " . __METHOD__);
        }
        return "custom_blog_posts." . $this->use_view_file;
    }


    /**
     * Does this object have an uploaded image of that size...?
     *
     * @param string $size
     * @return int
     */
    public function has_image($size = 'medium')
    {
        $this->check_valid_image_size($size);
        return strlen($this->{"image_" . $size});
    }

    /**
     * Get the full URL for an image
     * You should use ::has_image($size) to check if the size is valid
     *
     * @param string $size - should be 'medium' , 'large' or 'thumbnail'
     * @return string
     */
    public function image_url($size = 'medium')
    {
        $this->check_valid_image_size($size);
        $filename = $this->{"image_" . $size};
        return asset(config("binshopsblog.blog_upload_dir", "blog_images") . "/" . $filename);
    }

    /**
     * Generate a full <img src='' alt=''> img tag
     *
     * @param string $size - large, medium, thumbnail
     * @param boolean $auto_link - if true then itll add <a href=''>...</a> around the <img> tag
     * @param null|string $img_class - if you want any additional CSS classes for this tag for the <IMG>
     * @param null|string $anchor_class - is you want any additional CSS classes in the <a> anchor tag
     * @return string
     */
    public function image_tag($size = 'medium', $auto_link = true, $img_class = null, $anchor_class = null)
    {
        if (!$this->has_image($size)) {
            // return an empty string if this image does not exist.
            return '';
        }
        $url = e($this->image_url($size));
        $alt = e($this->title);
        $img = "<img src='$url' alt='$alt' class='" . e($img_class) . "' >";
        return $auto_link ? "<a class='" . e($anchor_class) . "' href='" . e($this->url( app()->getLocale() )) . "'>$img</a>" : $img;

    }

    public function generate_introduction($max_len = 500)
    {
        $base_text_to_use = $this->short_description;
        if (!trim($base_text_to_use)) {
            $base_text_to_use = $this->post_body;
        }
        $base_text_to_use = strip_tags($base_text_to_use);

        $intro = str_limit($base_text_to_use, (int)$max_len);
        return nl2br(e($intro));
    }

    public function post_body_output()
    {
        if (config("binshopsblog.use_custom_view_files") && $this->use_view_file) {
            // using custom view files is enabled, and this post has a use_view_file set, so render it:
            $return = view("binshopsblog::partials.use_view_file", ['post' => $this])->render();
        } else {
            // just use the plain ->post_body
            $return = $this->post_body;
        }


        if (!config("binshopsblog.echo_html")) {
            // if this is not true, then we should escape the output
            if (config("binshopsblog.strip_html")) {
                $return = strip_tags($return);
            }

            $return = e($return);
            if (config("binshopsblog.auto_nl2br")) {
                $return = nl2br($return);
            }
        }

        return $return;
    }


    /**
     * Throws an exception if $size is not valid
     * It should be either 'large','medium','thumbnail'
     * @param string $size
     * @return bool
     * @throws \InvalidArgumentException
     */
    protected function check_valid_image_size(string $size = 'medium')
    {


        if (array_key_exists("image_" . $size, config("binshopsblog.image_sizes"))) {
            return true;
        }

        // was an error!

        if (starts_with($size, "image_")) {
            // $size starts with image_, which is an error
            /* the config/binshopsblog.php and the DB columns SHOULD have keys that start with image_$size
            however when using methods such as image_url() or has_image() it SHOULD NOT start with 'image_'

            To put another way: :
                in the config/binshopsblog.php : config("binshopsblog.image_sizes.image_medium")
                in the database table:    : binshopsblog_posts.image_medium
                when calling image_url()  : image_url("medium")
            */
            throw new \InvalidArgumentException("Invalid image size ($size). BinshopsPost image size should not begin with 'image_'. Remove this from the start of $size. It *should* be in the binshopsblog.image_sizes config though!");
        }

        throw new \InvalidArgumentException("BinshopsPost image size should be 'large','medium','thumbnail' or another field as defined in config/binshopsblog.php. Provided size ($size) is not valid");
    }

    /**
     *
     * If $this->seo_title was set, return that.
     * Otherwise just return $this->title
     *
     * Basically return $this->seo_title ?? $this->title;
     * @return string
     */
    public function gen_seo_title()
    {
        if ($this->seo_title) {
            return $this->seo_title;
        }
        return $this->title;
    }

    /**
     * Returns the public facing URL to view this blog post
     *
     * @return string
     */
    public function url($loacle, $routeWithoutLocale = false)
    {
        return $routeWithoutLocale ? route("binshopsblog.single", ["", $this->slug]) : route("binshopsblog.single", [$loacle, $this->slug]);
    }

    /**
     * Return the URL for editing the post (used for admin users)
     * @return string
     */
    public function edit_url()
    {
        return route("binshopsblog.admin.edit_post", $this->post_id);
    }
}
