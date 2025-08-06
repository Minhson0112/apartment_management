<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImportProductTable extends Migration
{
    public function up()
    {
        Schema::create('import_product', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product');
            $table->unsignedBigInteger('supplier');
            $table->unsignedBigInteger('quantity');
            $table->unsignedBigInteger('price');
            $table->timestamps();

            $table->foreign('product')->references('id')->on('product');
            $table->foreign('supplier')->references('id')->on('suppliers');
        });
    }

    public function down()
    {
        Schema::dropIfExists('import_product');
    }
}