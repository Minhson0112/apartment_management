<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerImageTable extends Migration
{
    public function up()
    {
        Schema::create('owner_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner');
            $table->string('image_file_name');
            $table->timestamps();

            $table->foreign('owner')->references('cccd')->on('owner');
        });
    }

    public function down()
    {
        Schema::dropIfExists('owner_image');
    }
}
