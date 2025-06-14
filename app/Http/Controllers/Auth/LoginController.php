<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginAttempt;
use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LoginController extends Controller
{
    protected $maxAttempts = 5;
    protected $lockoutMinutes = 30;

    public function showLoginForm()
    {
        // Jika ada status admin_required, pastikan alert tetap muncul
        if (session('status') === 'admin_required') {
            session()->flash('admin_access_attempt', true);
            session()->flash('warning', 'Untuk mengakses panel admin, Anda harus login terlebih dahulu menggunakan akun admin. Silakan masukkan email dan password admin Anda.');
        }
        
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah akun terkunci
        if (LoginAttempt::isLocked($credentials['email'], $request->ip(), $this->maxAttempts, $this->lockoutMinutes)) {
            $lockoutTimeLeft = LoginAttempt::getLockoutTimeLeft($credentials['email'], $request->ip(), $this->lockoutMinutes);
            $minutesLeft = ceil($lockoutTimeLeft / 60);
            
            AuditLog::log('login_attempt', 'failed', [
                'email' => $credentials['email'],
                'reason' => 'account_locked',
                'lockout_time_left' => $minutesLeft
            ]);
            
            return back()->withErrors([
                'email' => "Akun terkunci karena terlalu banyak percobaan login yang gagal. Silakan coba lagi dalam {$minutesLeft} menit.",
            ])->onlyInput('email');
        }

        // Coba login
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // Login berhasil
            LoginAttempt::create([
                'email' => $credentials['email'],
                'ip_address' => $request->ip(),
                'attempted_at' => now(),
                'success' => true
            ]);

            AuditLog::log('login', 'success', [
                'email' => $credentials['email']
            ]);

            $request->session()->regenerate();

            // Redirect ke URL yang diakses sebelumnya jika ada
            if (session()->has('url.intended')) {
                $intendedUrl = session()->get('url.intended');
                session()->forget('url.intended');
                return redirect($intendedUrl);
            }

            if (Auth::user()->is_admin) {
                return redirect()->intended('admin');
            }

            return redirect()->intended('/');
        }

        // Login gagal
        LoginAttempt::create([
            'email' => $credentials['email'],
            'ip_address' => $request->ip(),
            'attempted_at' => now(),
            'success' => false
        ]);

        AuditLog::log('login', 'failed', [
            'email' => $credentials['email'],
            'reason' => 'invalid_credentials'
        ]);

        $failedAttempts = LoginAttempt::getFailedAttempts($credentials['email'], $request->ip(), $this->lockoutMinutes);
        $attemptsLeft = $this->maxAttempts - $failedAttempts;

        return back()->withErrors([
            'email' => $attemptsLeft > 0 
                ? "Email atau password yang dimasukkan tidak sesuai. Sisa percobaan: {$attemptsLeft}"
                : "Terlalu banyak percobaan login yang gagal. Akun terkunci selama {$this->lockoutMinutes} menit.",
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        if (auth()->check()) {
            AuditLog::log('logout', 'success', [
                'email' => auth()->user()->email
            ]);
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
} 