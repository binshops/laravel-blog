<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBinshopsBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binshops_blog_posts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger("user_id")->index()->nullable();
            $table->string("slug")->unique();

            $table->string("title")->nullable()->default("New blog post");
            $table->string("subtitle")->nullable()->default("");
            $table->text("meta_desc")->nullable();
            $table->mediumText("post_body")->nullable();

            $table->string("use_view_file")->nullable()->comment("should refer to a blade file in /views/");

            $table->dateTime("posted_at")->index()->nullable()->comment("Public posted at time, if this is in future then it wont appear yet");
            $table->boolean("is_published")->default(true);

            $table->string('image_large')->nullable();
            $table->string('image_medium')->nullable();
            $table->string('image_thumbnail')->nullable();

            $table->timestamps();
        });

        Schema::create('binshops_blog_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string("category_name")->nullable();
            $table->string("slug")->unique();
            $table->mediumText("category_description")->nullable();

            $table->unsignedInteger("created_by")->nullable()->index()->comment("user id");

            $table->timestamps();
        });

        Schema::create('binshops_blog_post_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("binshops_blog_post_id")->index();
            $table->foreign('binshops_blog_post_id')->references('id')->on('binshops_blog_posts')->onDelete("cascade");

            $table->unsignedInteger("binshops_blog_category_id")->index();
            $table->foreign('binshops_blog_category_id')->references('id')->on('binshops_blog_categories')->onDelete("cascade");
        });


        Schema::create('binshops_blog_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("binshops_blog_post_id")->index();
            $table->foreign('binshops_blog_post_id')->references('id')->on('binshops_blog_posts')->onDelete("cascade");
            $table->unsignedInteger("user_id")->nullable()->index()->comment("if user was logged in");

            $table->string("ip")->nullable()->comment("if enabled in the config file");
            $table->string("author_name")->nullable()->comment("if not logged in");

            $table->text("comment")->comment("the comment body");

            $table->boolean("approved")->default(true);

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
        Schema::dropIfExists('binshops_blog_post_categories');
        Schema::dropIfExists('binshops_blog_categories');
        Schema::dropIfExists('binshops_blog_posts');
    }
}
