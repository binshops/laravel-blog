<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinshopsFieldsValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binshops_field_values', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('field_id');
            $table->foreign('field_id')->references('id')->on('binshops_fields');

            $table->unsignedInteger('post_id');
            $table->foreign('post_id')->references('id')->on('binshops_posts');
            $table->string("value");
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
        Schema::dropIfExists('binshops_field_values');
    }
}
