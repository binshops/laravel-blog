<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateBlogEtcUploadedPhotosTable.
 */
class CreateBlogEtcUploadedPhotosTable extends Migration
{
    /**
     * Create the DB table for Blog Etc photos.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('blog_etc_uploaded_photos', static function (Blueprint $table) {
            $table->increments('id');
            $table->text('uploaded_images')->nullable();
            $table->string('image_title')->nullable();
            $table->string('source')->default('unknown');
            $table->unsignedInteger('uploader_id')->nullable()->index();

            $table->timestamps();
        });
        Schema::table('blog_etc_posts', static function (Blueprint $table) {
            $table->string('seo_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_etc_uploaded_photos');

        Schema::table('blog_etc_posts', static function (Blueprint $table) {
            $table->dropColumn('seo_title');
        });
    }
}
