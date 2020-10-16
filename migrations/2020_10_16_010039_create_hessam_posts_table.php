<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHessamPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hessam_posts', function (Blueprint $table) {
            $table->increments('post_id');
            $table->unsignedInteger("user_id")->index()->nullable();

            $table->dateTime("posted_at")->index()->nullable()->comment("Public posted at time, if this is in future then it wont appear yet");
            $table->boolean("is_published")->default(true);

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
        Schema::dropIfExists('hessam_posts');
    }
}
