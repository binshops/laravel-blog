<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class AddAuthorAndUrlBlogEtcPostsTable.
 */
class AddAuthorAndUrlBlogEtcPostsTable extends Migration
{
    /**
     * Add author_email and author_website columns to Blog Etc comments table.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('blog_etc_comments', static function (Blueprint $table) {
            $table->string('author_email')->nullable();
            $table->string('author_website')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('blog_etc_comments', static function (Blueprint $table) {
            $table->dropColumn('author_email');
            $table->dropColumn('author_website');
        });
    }
}
