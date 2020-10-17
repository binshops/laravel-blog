<?php


namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;

class HessamPostTranslation
{
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
        return $this->belongsTo(HessamPost::class, 'post_id');
    }

    /**
     * The associated Language
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function language()
    {
        return $this->hasOne(HessamLanguage::class,"lang_id");
    }

}