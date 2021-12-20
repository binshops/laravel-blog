<?php

namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class BinshopsPost
 * @package BinshopsBlog\Models
 */
class BinshopsFieldValue extends Model
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
        'field_id',
        'post_id',
        'value',
    ];

    /**
     * The associated BinshopsPost
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(BinshopsPost::class,"post_id");
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
