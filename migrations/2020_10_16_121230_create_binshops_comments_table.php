<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinshopsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binshops_comments', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger("post_id")->index();
            $table->unsignedInteger("user_id")->nullable()->index()->comment("if user was logged in");

            $table->string("ip")->nullable()->comment("if enabled in the config file");
            $table->string("author_name")->nullable()->comment("if not logged in");

            $table->text("comment")->comment("the comment body");

            $table->boolean("approved")->default(true);

            $table->string("author_email")->nullable();
            $table->string("author_website")->nullable();

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
        Schema::dropIfExists('binshops_comments');
    }
}
