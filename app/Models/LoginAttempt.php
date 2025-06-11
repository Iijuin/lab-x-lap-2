<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = [
        'email',
        'ip_address',
        'attempted_at',
        'success'
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
        'success' => 'boolean'
    ];

    public static function getFailedAttempts($email, $ipAddress, $minutes = 30)
    {
        return self::where('email', $email)
            ->where('ip_address', $ipAddress)
            ->where('success', false)
            ->where('attempted_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    public static function isLocked($email, $ipAddress, $maxAttempts = 5, $lockoutMinutes = 30)
    {
        $failedAttempts = self::getFailedAttempts($email, $ipAddress, $lockoutMinutes);
        return $failedAttempts >= $maxAttempts;
    }

    public static function getLockoutTimeLeft($email, $ipAddress, $lockoutMinutes = 30)
    {
        $lastAttempt = self::where('email', $email)
            ->where('ip_address', $ipAddress)
            ->where('success', false)
            ->latest('attempted_at')
            ->first();

        if (!$lastAttempt) {
            return 0;
        }

        $lockoutEnds = $lastAttempt->attempted_at->addMinutes($lockoutMinutes);
        return max(0, now()->diffInSeconds($lockoutEnds));
    }
} 