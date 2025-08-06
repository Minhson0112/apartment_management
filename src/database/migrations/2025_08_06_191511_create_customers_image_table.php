<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersImageTable extends Migration
{
    public function up()
    {
        Schema::create('customers_image', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer');
            $table->string('image_file_name');
            $table->timestamps();

            $table->foreign('customer')->references('cccd')->on('customers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers_image');
    }
}
