<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('customer');
            $table->unsignedBigInteger('apartment');
            $table->date('check_in_date');
            $table->date('check_out_date');
            $table->enum('status', ['1','2','3','4']);
            $table->unsignedBigInteger('price');
            $table->unsignedBigInteger('incidental_costs');
            $table->enum('payment_status', ['1','2']);
            $table->boolean('needer_bill');
            $table->string('note');
            $table->timestamps();

            $table->foreign('customer')->references('cccd')->on('customers');
            $table->foreign('apartment')->references('id')->on('apartment');
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
