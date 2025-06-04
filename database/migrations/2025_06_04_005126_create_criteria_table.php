<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('criteria', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code');
            $table->text('description')->nullable();
            $table->integer('priority_rank'); // 1 = highest priority
            $table->decimal('relative_importance', 3, 2)->default(1.00); // sj value
            $table->decimal('coefficient', 4, 3)->default(1.000); // kj value
            $table->decimal('weight', 4, 3)->default(0.000); // wj value
            $table->enum('type', ['benefit', 'cost'])->default('benefit');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('criteria');
    }
};