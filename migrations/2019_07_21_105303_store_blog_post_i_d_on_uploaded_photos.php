<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class StoreBlogPostIDOnUploadedPhotos
 * Create the new column on blog_etc_uploaded_photos to store the blog post ID (if it was associated with a blog post
 * id when created).
 */
class StoreBlogPostIDOnUploadedPhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_etc_uploaded_photos', function (Blueprint $table) {
            $table->unsignedInteger('blog_etc_post_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blog_etc_uploaded_photos', function (Blueprint $table) {
            $table->dropColumn('blog_etc_post_id');
        });
    }
}
