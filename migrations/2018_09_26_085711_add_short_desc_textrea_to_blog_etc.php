<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// (ignore typo! Don't want to change in case it breaks some people's migrations!)

/**
 * Class AddShortDescTextreaToBlogEtc.
 */
class AddShortDescTextreaToBlogEtc extends Migration
{
    /**
     * Create the DB table changes to add TEXT short_description column.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('blog_etc_posts', static function (Blueprint $table) {
            $table->text('short_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('blog_etc_posts', static function (Blueprint $table) {
            $table->dropColumn('short_description');
        });
    }
}
