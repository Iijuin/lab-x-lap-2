<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laptop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'processor',
        'ram',
        'storage',
        'gpu',
        'screen_size',
        'price',
        'image',
        'description',
        'is_active',
        'processor_score',
        'ram_score',
        'storage_score',
        'gpu_score',
        'screen_score',
        'price_score'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'processor_score' => 'decimal:2',
        'ram_score' => 'decimal:2',
        'storage_score' => 'decimal:2',
        'gpu_score' => 'decimal:2',
        'screen_score' => 'decimal:2',
        'price_score' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    // Get formatted price
    public function getFormattedPriceAttribute()
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    // Get all criteria scores as array
    public function getCriteriaScores()
    {
        return [
            'processor' => $this->processor_score,
            'ram' => $this->ram_score,
            'storage' => $this->storage_score,
            'gpu' => $this->gpu_score,
            'screen' => $this->screen_score,
            'price' => $this->price_score
        ];
    }

    // Auto-calculate scores when laptop is saved
    protected static function boot()
    {
        parent::boot();
        
        static::saving(function ($laptop) {
            $laptop->calculateScores();
        });
    }

    public function calculateScores()
    {
        // Processor scoring (simplified)
        $processorMap = [
            'Intel Core i3' => 0.3,
            'Intel Core i5' => 0.6,
            'Intel Core i7' => 0.9,
            'Intel Core i9' => 1.0,
            'AMD Ryzen 3' => 0.3,
            'AMD Ryzen 5' => 0.6,
            'AMD Ryzen 7' => 0.9,
            'AMD Ryzen 9' => 1.0
        ];
        
        $this->processor_score = $this->getScoreFromMap($this->processor, $processorMap);
        
        // RAM scoring
        $ramValue = (int) filter_var($this->ram, FILTER_SANITIZE_NUMBER_INT);
        $this->ram_score = min($ramValue / 32, 1.0); // Normalize to 32GB max
        
        // Storage scoring
        $storageScore = 0.3; // HDD base
        if (strpos(strtolower($this->storage), 'ssd') !== false) {
            $storageScore = 0.8; // SSD bonus
        }
        $storageValue = (int) filter_var($this->storage, FILTER_SANITIZE_NUMBER_INT);
        $this->storage_score = min(($storageScore + ($storageValue / 2000)), 1.0);
        
        // GPU scoring
        $gpuMap = [
            'Intel UHD' => 0.1,
            'Intel Iris Xe' => 0.3,
            'Radeon Graphics' => 0.3,
            'GTX 1650' => 0.5,
            'RTX 3050' => 0.7,
            'RTX 3060' => 0.9,
            'RTX 4060' => 1.0
        ];
        
        $this->gpu_score = $this->getScoreFromMap($this->gpu, $gpuMap);
        
        // Screen scoring
        $screenSize = (float) filter_var($this->screen_size, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $this->screen_score = min($screenSize / 17, 1.0); // Normalize to 17" max
        
        // Price scoring (inverse - lower price = higher score)
        $maxPrice = 20000000; // 20 million as max reference
        $this->price_score = max((($maxPrice - $this->price) / $maxPrice), 0);
    }

    private function getScoreFromMap($value, $map)
    {
        foreach ($map as $key => $score) {
            if (strpos(strtolower($value), strtolower($key)) !== false) {
                return $score;
            }
        }
        return 0.1; // Default low score
    }
}