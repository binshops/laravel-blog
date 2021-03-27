<?php

namespace BinshopsBlog\Models;

use Illuminate\Database\Eloquent\Model;

class BinshopsBlogUploadedPhoto extends Model
{
    public $table = 'binshops_blog_uploaded_photos';
    public $casts = [
        'uploaded_images' => 'array',
    ];
    public $fillable = [

        'image_title',
        'uploader_id',
        'source', 'uploaded_images',
    ];
}
