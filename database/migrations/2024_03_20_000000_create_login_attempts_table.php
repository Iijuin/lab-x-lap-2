<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('login_attempts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('ip_address', 45);
            $table->timestamp('attempted_at');
            $table->boolean('success');
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['email', 'ip_address']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('login_attempts');
    }
}; 