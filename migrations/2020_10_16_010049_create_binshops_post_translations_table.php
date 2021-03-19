<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinshopsPostTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binshops_post_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('post_id')->nullable();

            $table->string("slug");
            $table->string("title")->nullable()->default("New blog post");
            $table->string("subtitle")->nullable()->default("");
            $table->text("meta_desc")->nullable();
            $table->string("seo_title")->nullable();
            $table->mediumText("post_body")->nullable();
            $table->text("short_description")->nullable();

            $table->string("use_view_file")->nullable()->comment("should refer to a blade file in /views/");

            $table->string('image_large')->nullable();
            $table->string('image_medium')->nullable();
            $table->string('image_thumbnail')->nullable();

            $table->unsignedInteger("lang_id")->index();
            $table->foreign('lang_id')->references('id')->on('binshops_languages');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('binshops_post_translations');
    }
}
