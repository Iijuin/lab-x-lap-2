<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('user_responses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('program');
            $table->json('activities'); // Store as JSON
            $table->string('budget');
            $table->string('ram');
            $table->string('storage');
            $table->string('gpu');
            $table->string('screen');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_responses');
    }
};