<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBinshopsLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('binshops_languages', function (Blueprint $table) {
            $table->increments('id');

            $table->string("name")->unique();
            $table->string("locale")->unique();
            $table->string("iso_code")->unique();
            $table->string("date_format");
            $table->boolean("active")->default(true);
            $table->boolean("rtl")->default(false);

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
        Schema::dropIfExists('binshops_languages');
    }
}
