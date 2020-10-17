<?php


namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;

class HessamLanguage
{
    public $fillable = [
        'name',
        'locale',
        'iso_code',
        'date_format',
        'active'
    ];


    /**
     * The associated post (if post_id) is set
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(HessamPost::class, 'post_id');
    }

    /**
     * The associated author (if category_id) is set
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(HessamCategory::class, 'category_id');
    }

}