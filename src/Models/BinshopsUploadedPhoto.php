<?php

namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;

class BinshopsUploadedPhoto extends Model
{
    public $table = 'binshops_uploaded_photos';
    public $casts = [
        'uploaded_images' => 'array',
    ];
    public $fillable = [

        'image_title',
        'uploader_id',
        'source', 'uploaded_images',
    ];
}
