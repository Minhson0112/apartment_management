<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractExtensionTable extends Migration
{
    public function up()
    {
        Schema::create('contract_extension', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('apartment');
            $table->date('rent_start_time');
            $table->date('rent_end_time');
            $table->unsignedBigInteger('rent_price');
            $table->timestamps();

            $table->foreign('apartment')->references('id')->on('apartment');
        });
    }

    public function down()
    {
        Schema::dropIfExists('contract_extension');
    }
}
