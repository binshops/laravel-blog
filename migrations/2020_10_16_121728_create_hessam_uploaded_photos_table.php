<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHessamUploadedPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hessam_uploaded_photos', function (Blueprint $table) {
            $table->increments('id');
            $table->text("uploaded_images")->nullable();
            $table->string("image_title")->nullable();
            $table->string("source")->default("unknown");
            $table->unsignedInteger("uploader_id")->nullable()->index();
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
        Schema::dropIfExists('hessam_uploaded_photos');
    }
}
