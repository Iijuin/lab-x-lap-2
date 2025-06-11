<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laptop_recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_response_id')->constrained()->onDelete('cascade');
            $table->foreignId('laptop_id')->constrained()->onDelete('cascade');
            $table->decimal('score', 5, 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laptop_recommendations');
    }
}; 