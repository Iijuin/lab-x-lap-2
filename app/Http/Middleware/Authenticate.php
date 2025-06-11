<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->is('admin*')) {
            session()->flash('admin_access_attempt', true);
            session()->flash('warning', 'Untuk mengakses panel admin, Anda harus login terlebih dahulu menggunakan akun admin Anda. Silakan masukkan email dan password admin Anda.');
        }
        
        return $request->expectsJson() ? null : route('login');
    }
} 