<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{
    protected $fillable = [
        'user_id',
        'action',
        'ip_address',
        'user_agent',
        'details',
        'status'
    ];

    protected $casts = [
        'details' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function log($action, $status = 'success', $details = null)
    {
        return self::create([
            'user_id' => auth()->id(),
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'details' => $details,
            'status' => $status
        ]);
    }
} 