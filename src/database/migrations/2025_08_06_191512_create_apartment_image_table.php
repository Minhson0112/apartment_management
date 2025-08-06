<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateApartmentImageTable extends Migration
{
    public function up()
    {
        Schema::create('apartment_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apartment');
            $table->string('image_file_name');
            $table->timestamps();

            $table->foreign('apartment')->references('id')->on('apartment');
        });
    }

    public function down()
    {
        Schema::dropIfExists('apartment_image');
    }
}
