<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserResponse;
use App\Models\Laptop;

class ResultController extends Controller
{
    /**
     * Display the latest results or redirect to questions if no data exists
     */
    public function index()
    {
        // Get the latest user response
        $userResponse = UserResponse::latest()->first();
        
        if (!$userResponse) {
            return redirect()->route('questions.index')
                           ->with('info', 'Silakan isi form terlebih dahulu untuk melihat rekomendasi.');
        }
        
        // Generate recommendations
        $recommendations = $this->generateRecommendations($userResponse);
        
        return view('user.results', compact('userResponse', 'recommendations'));
    }

    /**
     * Display specific result by ID
     */
    public function show($id)
    {
        $userResponse = UserResponse::findOrFail($id);
        $recommendations = $this->generateRecommendations($userResponse);
        
        return view('user.results', compact('userResponse', 'recommendations'));
    }

    /**
     * Generate laptop recommendations based on user responses
     */
    private function generateRecommendations(UserResponse $userResponse)
    {
        // Get laptops within budget range
        $laptops = Laptop::whereBetween('price', [$userResponse->min_budget, $userResponse->max_budget])
                        ->get();

        if ($laptops->isEmpty()) {
            // If no laptops in exact budget, get closest ones
            $laptops = Laptop::orderByRaw('ABS(price - ?)', [($userResponse->min_budget + $userResponse->max_budget) / 2])
                            ->limit(10)
                            ->get();
        }

        // Calculate compatibility score for each laptop
        $recommendations = [];
        
        foreach ($laptops as $laptop) {
            $score = $this->calculateCompatibilityScore($laptop, $userResponse);
            
            if ($score > 0) {
                $laptop->score = $score;
                $recommendations[] = $laptop;
            }
        }

        // Sort by score (highest first)
        usort($recommendations, function ($a, $b) {
            return $b->score <=> $a->score;
        });

        // Return top 6 recommendations
        return array_slice($recommendations, 0, 6);
    }

    /**
     * Calculate compatibility score between laptop and user preferences
     */
    private function calculateCompatibilityScore($laptop, $userResponse)
    {
        $score = 0;
        $maxScore = 100;

        // Budget compatibility (30% weight)
        if ($laptop->price >= $userResponse->min_budget && 
            $laptop->price <= $userResponse->max_budget) {
            $score += 30;
        } else {
            // Partial score if close to budget
            $budgetCenter = ($userResponse->min_budget + $userResponse->max_budget) / 2;
            $budgetRange = $userResponse->max_budget - $userResponse->min_budget;
            $priceDifference = abs($laptop->price - $budgetCenter);
            
            if ($priceDifference <= $budgetRange * 0.5) {
                $score += 15; // Half points if within 50% of budget range
            }
        }

        // Activities compatibility (35% weight)
        $activities = $userResponse->activities;
        $activityScore = 0;
        
        foreach ($activities as $activity) {
            switch ($activity) {
                case 'programming':
                    if (stripos($laptop->processor, 'i5') !== false || 
                        stripos($laptop->processor, 'i7') !== false ||
                        stripos($laptop->processor, 'ryzen') !== false) {
                        $activityScore += 8;
                    }
                    if (isset($laptop->ram) && $laptop->ram >= 8) {
                        $activityScore += 7;
                    }
                    break;
                    
                case 'desain':
                    if (isset($laptop->graphics) && 
                        (stripos($laptop->graphics, 'gtx') !== false || 
                         stripos($laptop->graphics, 'rtx') !== false ||
                         stripos($laptop->graphics, 'radeon') !== false)) {
                        $activityScore += 10;
                    }
                    if (isset($laptop->screen_size) && $laptop->screen_size >= 15) {
                        $activityScore += 5;
                    }
                    break;
                    
                case 'machine-learning':
                    if (isset($laptop->graphics) && 
                        (stripos($laptop->graphics, 'rtx') !== false || 
                         stripos($laptop->graphics, 'gtx 1660') !== false)) {
                        $activityScore += 15;
                    }
                    if (isset($laptop->ram) && $laptop->ram >= 16) {
                        $activityScore += 10;
                    }
                    break;
                    
                case 'game-dev':
                    if (isset($laptop->graphics) && 
                        stripos($laptop->graphics, 'rtx') !== false) {
                        $activityScore += 12;
                    }
                    if (stripos($laptop->processor, 'i7') !== false || 
                        stripos($laptop->processor, 'ryzen 7') !== false) {
                        $activityScore += 8;
                    }
                    break;
                    
                case 'office':
                    if (isset($laptop->battery_life) && $laptop->battery_life >= 6) {
                        $activityScore += 5;
                    }
                    if (isset($laptop->weight) && $laptop->weight <= 2.5) {
                        $activityScore += 5;
                    }
                    break;
            }
        }
        
        $score += min($activityScore, 35); // Cap at 35 points

        // RAM compatibility (15% weight)
        $userRamPreference = $userResponse->ram;
        if (isset($laptop->ram)) {
            switch ($userRamPreference) {
                case '4gb':
                    if ($laptop->ram >= 4) $score += 15;
                    break;
                case '8gb':
                    if ($laptop->ram >= 8) $score += 15;
                    elseif ($laptop->ram >= 4) $score += 10;
                    break;
                case '16gb':
                    if ($laptop->ram >= 16) $score += 15;
                    elseif ($laptop->ram >= 8) $score += 10;
                    break;
                case '32gb':
                    if ($laptop->ram >= 32) $score += 15;
                    elseif ($laptop->ram >= 16) $score += 12;
                    break;
            }
        }

        // Storage compatibility (10% weight)
        $userStoragePreference = $userResponse->storage;
        if (isset($laptop->storage)) {
            $isSSD = stripos($laptop->storage, 'ssd') !== false;
            $storageSize = (int) filter_var($laptop->storage, FILTER_SANITIZE_NUMBER_INT);
            
            switch ($userStoragePreference) {
                case 'hdd-500gb':
                    if ($storageSize >= 500) $score += 10;
                    break;
                case 'hdd-1tb':
                    if ($storageSize >= 1000) $score += 10;
                    break;
                case 'ssd-256gb':
                    if ($isSSD && $storageSize >= 256) $score += 10;
                    elseif ($isSSD) $score += 7;
                    break;
                case 'ssd-1tb':
                    if ($isSSD && $storageSize >= 1000) $score += 10;
                    elseif ($isSSD && $storageSize >= 512) $score += 8;
                    break;
            }
        }

        // GPU compatibility (10% weight)
        $userGpuPreference = $userResponse->gpu;
        if (isset($laptop->graphics)) {
            switch ($userGpuPreference) {
                case 'no-gpu':
                case 'integrated':
                    if (stripos($laptop->graphics, 'integrated') !== false ||
                        stripos($laptop->graphics, 'intel') !== false) {
                        $score += 10;
                    }
                    break;
                case 'entry-level':
                    if (stripos($laptop->graphics, 'gtx 1650') !== false ||
                        stripos($laptop->graphics, 'mx') !== false) {
                        $score += 10;
                    }
                    break;
                case 'mid-range':
                    if (stripos($laptop->graphics, 'gtx 1660') !== false ||
                        stripos($laptop->graphics, 'rtx 3050') !== false) {
                        $score += 10;
                    }
                    break;
                case 'high-end':
                    if (stripos($laptop->graphics, 'rtx 3060') !== false ||
                        stripos($laptop->graphics, 'rtx 3070') !== false ||
                        stripos($laptop->graphics, 'rtx 4060') !== false) {
                        $score += 10;
                    }
                    break;
            }
        }

        return min($score, $maxScore);
    }
}