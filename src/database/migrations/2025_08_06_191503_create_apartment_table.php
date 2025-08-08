<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentTable extends Migration
{
    public function up()
    {
        Schema::create('apartment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('apartment_name');
            $table->enum('type', ['1','2','3','4']);
            $table->unsignedBigInteger('area');
            $table->enum('status', ['1','2','3','4']);
            $table->date('check_in_date')->nullable();
            ;
            $table->date('check_out_date')->nullable();
            ;
            $table->unsignedBigInteger('apartment_owner');
            $table->unsignedBigInteger('appliances_price');
            $table->unsignedBigInteger('rent_price');
            $table->date('rent_start_time');
            $table->date('rent_end_time');
            $table->timestamps();

            $table->foreign('apartment_owner')->references('cccd')->on('owner');
        });
    }

    public function down()
    {
        Schema::dropIfExists('apartment');
    }
}
