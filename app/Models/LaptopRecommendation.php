<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaptopRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_response_id',
        'laptop_id',
        'score',
    ];

    public function userResponse()
    {
        return $this->belongsTo(UserResponse::class);
    }

    public function laptop()
    {
        return $this->belongsTo(Laptop::class);
    }
} 