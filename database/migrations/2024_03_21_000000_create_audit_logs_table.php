<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action'); // login, logout, role_change, permission_change, data_access
            $table->string('ip_address', 45);
            $table->string('user_agent')->nullable();
            $table->json('details')->nullable();
            $table->string('status'); // success, failed, warning
            $table->timestamps();
            
            // Index untuk pencarian cepat
            $table->index(['user_id', 'action', 'created_at']);
            $table->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
}; 