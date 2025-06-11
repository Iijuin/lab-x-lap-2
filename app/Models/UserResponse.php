<?php

namespace App\Models;

use App\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserResponse extends Model
{
    use HasFactory, Encryptable;

    protected $fillable = [
        'name',
        'program',
        'activities',
        'budget',
        'ram',
        'storage',
        'gpu',
        'screen',
        'user_id'
    ];

    protected $encryptable = [
        'name',
        'program'
    ];

    protected $casts = [
        'activities' => 'array', // Automatically handle JSON conversion
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recommendations()
    {
        return $this->hasMany(LaptopRecommendation::class);
    }

    // Helper methods to get budget range
    public function getMinBudgetAttribute()
    {
        $budgetRanges = [
            'less-5m' => 0,
            '5m-8m' => 5000000,
            '8m-12m' => 8000000,
            '12m-15m' => 12000000,
            'more-15m' => 15000000,
        ];

        return $budgetRanges[$this->budget] ?? 0;
    }

    public function getMaxBudgetAttribute()
    {
        $budgetRanges = [
            'less-5m' => 5000000,
            '5m-8m' => 8000000,
            '8m-12m' => 12000000,
            '12m-15m' => 15000000,
            'more-15m' => 50000000, // Set high limit for "more than 15m"
        ];

        return $budgetRanges[$this->budget] ?? 50000000;
    }

    // Get primary usage type based on activities
    public function getUsageTypeAttribute()
    {
        $activities = $this->activities;
        
        if (in_array('programming', $activities)) {
            return 'programming';
        } elseif (in_array('desain', $activities)) {
            return 'design';
        } elseif (in_array('game-dev', $activities)) {
            return 'gaming';
        } elseif (in_array('machine-learning', $activities)) {
            return 'machine-learning';
        } else {
            return 'office';
        }
    }

    // Get performance level based on activities and program
    public function getPerformanceLevelAttribute()
    {
        $activities = $this->activities;
        
        if (in_array('machine-learning', $activities) || 
            in_array('game-dev', $activities) ||
            ($this->program === 'Teknik Informatika' && count($activities) > 3)) {
            return 'high';
        } elseif (in_array('programming', $activities) || 
                  in_array('desain', $activities)) {
            return 'medium';
        } else {
            return 'low';
        }
    }

    // Tambahkan method ini di UserResponse model
    public function getActivitiesDisplayAttribute()
    {
        $activities = $this->activities;
        
        // Handle null or empty
        if (empty($activities)) {
            return 'Tidak ada aktivitas';
        }
        
        // Ensure it's array
        if (is_string($activities)) {
            $activities = json_decode($activities, true) ?? [$activities];
        }
        
        if (!is_array($activities)) {
            return $activities;
        }
        
        return implode(', ', $activities);
    }
}
