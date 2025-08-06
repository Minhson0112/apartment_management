<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUseProductTable extends Migration
{
    public function up()
    {
        Schema::create('use_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apartment');
            $table->unsignedBigInteger('product');
            $table->unsignedBigInteger('quantity');
            $table->timestamps();

            $table->foreign('apartment')->references('id')->on('apartment');
            $table->foreign('product')->references('id')->on('product');
        });
    }

    public function down()
    {
        Schema::dropIfExists('use_product');
    }
}
