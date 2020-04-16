<?php

namespace WebDevEtc\BlogEtc\Models;

use Illuminate\Database\Eloquent\Model;

class BlogEtcUploadedPhoto extends Model
{
    public $table = 'blog_etc_uploaded_photos';
    public $casts = [
        'uploaded_images' => 'array',
    ];
    public $fillable = [

        'image_title',
        'uploader_id',
        'source', 'uploaded_images',
    ];
}
