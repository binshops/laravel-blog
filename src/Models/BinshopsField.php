<?php

namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BinshopsPost
 * @package BinshopsBlog\Models
 */
class BinshopsField extends Model
{
    /**
     * @var array
     */
    public $casts = [

    ];

    /**
     * @var array
     */
    public $dates = [

    ];

    /**
     * @var array
     */
    public $fillable = [
        'label',
        'type',
        'validation',
    ];

    /**
     *
     */
    public function fieldTypes()
    {
       return [
           1 => 'text',
           2 => 'textarea',
           3 => 'number',
           4 => 'date',
           5 => 'url'
       ];
    }

    public function typeName()
    {
        return $this->fieldTypes()[$this->type];
    }

    /**
     * The associated categories for this blog post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(BinshopsCategory::class, 'binshops_field_categories','field_id','category_id');
    }

    /**
     * The associated categories for this blog post
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function values()
    {
        return $this->hasMany(BinshopsFieldValue::class, 'field_id');
    }


    /**
     * Returns the URL for an admin user to edit this category
     * @return string
     */
    public function edit_url()
    {
        return route("binshopsblog.admin.fields.edit_field", $this->id);
    }

    public function getClasses()
    {
        if(!$this->categories()->exists()) {
            return 'no_categories';
        }
        $classes = '';
        foreach($this->categories as $category){
            $classes .= 'field_category_' . $category->id . ' ';
        }
        return $classes;
    }
}