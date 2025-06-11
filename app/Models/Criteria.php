<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'priority_rank',
        'relative_importance',
        'coefficient',
        'weight',
        'type',
        'is_active'
    ];

    protected $casts = [
        'priority_rank' => 'integer',
        'relative_importance' => 'decimal:2',
        'coefficient' => 'decimal:3',
        'weight' => 'decimal:3',
        'is_active' => 'boolean'
    ];

    protected $table = 'criteria';

    // Get criteria ordered by priority
    public static function getByPriority()
    {
        return self::where('is_active', true)
                  ->orderBy('priority_rank')
                  ->get();
    }

    // Calculate SWARA weights for all criteria
    public static function calculateSwaraWeights()
    {
        $criteria = self::getByPriority();
        
        if ($criteria->isEmpty()) {
            return;
        }

        // Step 1: First criteria has coefficient = 1
        $firstCriteria = $criteria->first();
        $firstCriteria->coefficient = 1.000;
        $firstCriteria->save();

        // Step 2: Calculate coefficients for other criteria
        foreach ($criteria->skip(1) as $index => $criterion) {
            $kj = 1 + $criterion->relative_importance;
            $criterion->coefficient = $kj;
            $criterion->save();
        }

        // Step 3: Calculate recalculated weights (qj)
        $recalculatedWeights = [];
        foreach ($criteria as $index => $criterion) {
            if ($index === 0) {
                $recalculatedWeights[] = 1.000;
            } else {
                $previousWeight = $recalculatedWeights[$index - 1];
                $recalculatedWeights[] = $previousWeight / $criterion->coefficient;
            }
        }

        // Step 4: Calculate final weights (wj)
        $totalWeight = array_sum($recalculatedWeights);
        
        foreach ($criteria as $index => $criterion) {
            $weight = $recalculatedWeights[$index] / $totalWeight;
            $criterion->weight = $weight;
            $criterion->save();
        }
    }

    // Get weights as associative array
    public static function getWeightsArray()
    {
        return self::where('is_active', true)
                  ->pluck('weight', 'code')
                  ->toArray();
    }
}