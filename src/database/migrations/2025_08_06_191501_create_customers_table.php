<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('cccd')->primary();
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('phone_number');
            $table->string('email');
            $table->string('note');
            $table->unsignedBigInteger('origin');
            $table->timestamps();

            $table->foreign('origin')->references('id')->on('user');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
