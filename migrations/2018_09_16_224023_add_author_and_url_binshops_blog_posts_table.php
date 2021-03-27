<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthorAndUrlBinshopsBlogPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('binshops_blog_comments', function (Blueprint $table) {
            $table->string("author_email")->nullable();
            $table->string("author_website")->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('binshops_blog_comments', function (Blueprint $table) {
            $table->dropColumn("author_email");
            $table->dropColumn("author_website");
        });
    }
}

