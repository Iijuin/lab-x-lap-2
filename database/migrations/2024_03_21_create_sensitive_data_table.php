<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sensitive_data', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('phone_number');
            $table->text('address');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sensitive_data');
    }
}; 