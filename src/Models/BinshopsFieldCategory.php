<?php

namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BinshopsPost
 * @package BinshopsBlog\Models
 */
class BinshopsFieldCategory extends Model
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
    ];

    /**
     * The associated BinshopsCategory
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(BinshopsPost::class,"category_id");
    }

    /**
     * The associated BinshopsField
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function field()
    {
        return $this->belongsTo(BinshopsField::class,"field_id");
    }
}
