<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHessamCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hessam_categories', function (Blueprint $table) {
            $table->increments('category_id');

            $table->unsignedInteger("created_by")->nullable()->index()->comment("user id");

            //columns related to multi-level categories
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
            $table->integer('depth')->nullable();

            $table->timestamps();
        });

        Schema::create('hessam_post_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("post_id")->index();
            $table->foreign('post_id')->references('post_id')->on('hessam_posts')->onDelete("cascade");

            $table->unsignedInteger("category_id")->index();
            $table->foreign('category_id')->references('category_id')->on('hessam_categories')->onDelete("cascade");
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hessam_categories');
    }
}
