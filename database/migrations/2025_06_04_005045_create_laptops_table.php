<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('laptops', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('processor');
            $table->string('ram');
            $table->string('storage');
            $table->string('gpu');
            $table->string('screen_size');
            $table->decimal('price', 12, 2);
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Normalized values for SWARA calculation (0-1 scale)
            $table->decimal('processor_score', 3, 2)->default(0);
            $table->decimal('ram_score', 3, 2)->default(0);
            $table->decimal('storage_score', 3, 2)->default(0);
            $table->decimal('gpu_score', 3, 2)->default(0);
            $table->decimal('screen_score', 3, 2)->default(0);
            $table->decimal('price_score', 3, 2)->default(0);
            
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laptops');
    }
};