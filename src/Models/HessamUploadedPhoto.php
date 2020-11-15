<?php

namespace HessamCMS\Models;

use Illuminate\Database\Eloquent\Model;

class HessamUploadedPhoto extends Model
{
    public $table = 'hessam_uploaded_photos';
    public $casts = [
        'uploaded_images' => 'array',
    ];
    public $fillable = [

        'image_title',
        'uploader_id',
        'source', 'uploaded_images',
    ];
}
