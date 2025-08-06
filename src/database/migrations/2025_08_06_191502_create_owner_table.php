<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOwnerTable extends Migration
{
    public function up()
    {
        Schema::create('owner', function (Blueprint $table) {
            $table->unsignedBigInteger('cccd')->primary();
            $table->string('full_name');
            $table->date('date_of_birth')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('owner');
    }
}
