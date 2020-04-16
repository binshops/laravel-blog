<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShortDescTextreaToBlogEtc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blog_etc_posts', function (Blueprint $table) {
            $table->text("short_description")->nullable();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('blog_etc_posts', function (Blueprint $table) {
            $table->dropColumn("short_description");
        });
    }
}
