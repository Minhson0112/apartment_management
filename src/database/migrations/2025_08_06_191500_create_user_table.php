<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->unsignedBigInteger('cccd')->primary();
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->unsignedBigInteger('phone_number')->nullable();
            $table->string('mail')->nullable();
            $table->string('user_name');
            $table->string('password');
            $table->enum('role', ['1','2','3']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user');
    }
}
