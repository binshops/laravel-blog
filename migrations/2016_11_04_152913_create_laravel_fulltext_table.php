<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelFulltextTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('laravel-fulltext.db_connection'))->create('laravel_fulltext', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('indexable_id');
            $table->string('indexable_type');
            $table->text('indexed_title');
            $table->text('indexed_content');

            $table->unique(['indexable_type', 'indexable_id']);

            $table->timestamps();
        });

        DB::connection(config('laravel-fulltext.db_connection'))->statement('ALTER TABLE laravel_fulltext ADD FULLTEXT fulltext_title(indexed_title)');
        DB::connection(config('laravel-fulltext.db_connection'))->statement('ALTER TABLE laravel_fulltext ADD FULLTEXT fulltext_title_content(indexed_title, indexed_content)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('laravel-fulltext.db_connection'))->drop('laravel_fulltext');
    }
}
