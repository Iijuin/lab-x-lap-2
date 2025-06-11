<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\UserResponse;
use App\Services\CryptoService;

return new class extends Migration
{
    public function up()
    {
        // Pastikan kolom bisa menyimpan data terenkripsi
        Schema::table('user_responses', function (Blueprint $table) {
            $table->text('name')->change();
            $table->text('program')->change();
        });

        // Enkripsi data yang sudah ada
        $cryptoService = app(CryptoService::class);
        $responses = UserResponse::all();

        foreach ($responses as $response) {
            $response->name = $cryptoService->encrypt($response->name);
            $response->program = $cryptoService->encrypt($response->program);
            $response->save();
        }
    }

    public function down()
    {
        // Dekripsi data sebelum mengubah tipe kolom
        $cryptoService = app(CryptoService::class);
        $responses = UserResponse::all();

        foreach ($responses as $response) {
            try {
                $response->name = $cryptoService->decrypt($response->name);
                $response->program = $cryptoService->decrypt($response->program);
                $response->save();
            } catch (\Exception $e) {
                // Jika gagal dekripsi, biarkan data tetap terenkripsi
                continue;
            }
        }

        Schema::table('user_responses', function (Blueprint $table) {
            $table->string('name')->change();
            $table->string('program')->change();
        });
    }
}; 