<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use App\Http\Requests\PasswordValidationRequest;

class ResetPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        return view('auth.reset-password', [
            'token' => $request->token,
            'email' => $request->email
        ]);
    }

    public function reset(PasswordValidationRequest $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
        ]);

        // Cek apakah email adalah admin@example.com
        if ($request->email !== 'admin@example.com') {
            AuditLog::log('password_reset', 'failed', [
                'email' => $request->email,
                'reason' => 'not_admin_email'
            ]);

            return back()->withErrors([
                'email' => 'Email yang dimasukkan bukan email admin.',
            ]);
        }

        $user = User::where('email', $request->email)
                   ->where('password_reset_token', $request->token)
                   ->first();

        if (!$user) {
            AuditLog::log('password_reset', 'failed', [
                'email' => $request->email,
                'reason' => 'invalid_token'
            ]);

            return back()->withErrors([
                'email' => 'Token reset password tidak valid.',
            ]);
        }

        // Cek apakah token sudah kadaluarsa (60 menit)
        $tokenCreatedAt = $user->password_reset_token_created_at;
        if (!$tokenCreatedAt || !($tokenCreatedAt instanceof \Carbon\Carbon)) {
            try {
                $tokenCreatedAt = \Carbon\Carbon::parse($tokenCreatedAt);
            } catch (\Exception $e) {
                return back()->withErrors([
                    'email' => 'Token reset password tidak valid.',
                ]);
            }
        }
        if ($tokenCreatedAt->addMinutes(60)->isPast()) {
            AuditLog::log('password_reset', 'failed', [
                'email' => $request->email,
                'reason' => 'token_expired'
            ]);

            return back()->withErrors([
                'email' => 'Token reset password sudah kadaluarsa.',
            ]);
        }

        // Update password
        $user->forceFill([
            'password' => Hash::make($request->password),
            'password_reset_token' => null,
            'password_reset_token_created_at' => null,
        ])->save();

        AuditLog::log('password_reset', 'success', [
            'email' => $request->email
        ]);

        return redirect()->route('login')->with('status', 'Password berhasil direset. Silakan login dengan password baru Anda.');
    }
} 