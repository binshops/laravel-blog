<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBinshopsBlogUploadedPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binshops_blog_uploaded_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->text("uploaded_images")->nullable();
            $table->string("image_title")->nullable();
            $table->string("source")->default("unknown");
            $table->unsignedInteger("uploader_id")->nullable()->index();
            $table->timestamps();
        });
        Schema::table("binshops_blog_posts",function(Blueprint $table) {
            $table->string("seo_title")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('binshops_blog_uploaded_photos');

        Schema::table("binshops_blog_posts",function(Blueprint $table) {
            $table->dropColumn("seo_title");
        });
    }
}
