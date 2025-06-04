<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('user_responses', function (Blueprint $table) {
            if (!Schema::hasColumn('user_responses', 'name')) {
                $table->string('name');
            }
            // Add other columns with similar checks if needed
        });
    }

    public function down()
    {
        Schema::table('user_responses', function (Blueprint $table) {
            if (Schema::hasColumn('user_responses', 'name')) {
                $table->dropColumn('name');
            }
        });
    }
};