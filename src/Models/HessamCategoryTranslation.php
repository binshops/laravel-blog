<?php


namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;

class HessamCategoryTranslation extends Model
{

    public $fillable = [
        'category_name',
        'slug',
        'category_description',
        'parent_id'
    ];

    /**
     * Get the user that owns the phone.
     */
    public function category()
    {
        return $this->belongsTo(HessamCategory::class, 'category_id');
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