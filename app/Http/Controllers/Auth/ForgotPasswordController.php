<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Cek apakah email adalah admin@example.com
        if ($request->email !== 'admin@example.com') {
            AuditLog::log('password_reset_request', 'failed', [
                'email' => $request->email,
                'reason' => 'not_admin_email'
            ]);

            return back()->withErrors([
                'email' => 'Email yang dimasukkan bukan email admin.',
            ]);
        }

        // Generate token reset password
        $token = Str::random(64);
        $user = User::where('email', 'admin@example.com')->first();
        
        // Simpan token ke database
        $user->forceFill([
            'password_reset_token' => $token,
            'password_reset_token_created_at' => now()
        ])->save();

        AuditLog::log('password_reset_request', 'success', [
            'email' => $request->email
        ]);

        // Redirect ke halaman reset password dengan token
        return redirect()->route('password.reset', [
            'token' => $token,
            'email' => $request->email
        ])->with('status', 'Silakan masukkan password baru Anda.');
    }
} 