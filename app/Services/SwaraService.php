<?php

namespace App\Services;

use App\Models\Laptop;
use App\Models\Criteria;
use App\Models\UserResponse;

class SwaraService
{
    /**
     * Get laptop recommendations based on user preferences
     */
    public function getRecommendations(UserResponse $userResponse, $limit = 5)
    {
        // Get active laptops
        $laptops = Laptop::where('is_active', true)->get();
        
        if ($laptops->isEmpty()) {
            return collect();
        }

        // Get criteria weights
        $weights = Criteria::getWeightsArray();
        
        if (empty($weights)) {
            // If no weights configured, use equal weights
            $weights = [
                'processor' => 0.167,
                'ram' => 0.167,
                'storage' => 0.167,
                'gpu' => 0.167,
                'screen' => 0.167,
                'price' => 0.165
            ];
        }

        // Filter laptops based on user preferences
        $filteredLaptops = $this->filterByUserPreferences($laptops, $userResponse);

        // Calculate SWARA scores
        $scoredLaptops = $this->calculateSwaraScores($filteredLaptops, $weights, $userResponse);

        // Sort by score and return top recommendations
        return $scoredLaptops->sortByDesc('swara_score')->take($limit);
    }

    /**
     * Filter laptops based on user preferences
     */
    private function filterByUserPreferences($laptops, UserResponse $userResponse)
    {
        return $laptops->filter(function ($laptop) use ($userResponse) {
            // Budget filter
            $budgetMatch = $this->checkBudgetMatch($laptop->price, $userResponse->budget);
            
            // RAM filter based on activities
            $ramMatch = $this->checkRamMatch($laptop->ram, $userResponse->activities);
            
            // GPU filter based on activities
            $gpuMatch = $this->checkGpuMatch($laptop->gpu, $userResponse->activities);
            
            // Screen size filter
            $screenMatch = $this->checkScreenMatch($laptop->screen_size, $userResponse->screen);

            return $budgetMatch && $ramMatch && $gpuMatch && $screenMatch;
        });
    }

    /**
     * Calculate SWARA scores for laptops
     */
    private function calculateSwaraScores($laptops, $weights, $userResponse)
    {
        return $laptops->map(function ($laptop) use ($weights, $userResponse) {
            $scores = $laptop->getCriteriaScores();
            
            // Calculate weighted score
            $totalScore = 0;
            foreach ($weights as $criterion => $weight) {
                if (isset($scores[$criterion])) {
                    $totalScore += $scores[$criterion] * $weight;
                }
            }

            // Add preference bonus
            $preferenceBonus = $this->calculatePreferenceBonus($laptop, $userResponse);
            $finalScore = $totalScore + $preferenceBonus;

            $laptop->swara_score = round($finalScore, 4);
            $laptop->preference_bonus = $preferenceBonus;
            
            return $laptop;
        });
    }

    /**
     * Check if laptop price matches user budget
     */
    private function checkBudgetMatch($price, $budget)
    {
        switch ($budget) {
            case 'less-5m':
                return $price < 5000000;
            case '5m-8m':
                return $price >= 5000000 && $price <= 8000000;
            case '8m-12m':
                return $price >= 8000000 && $price <= 12000000;
            case '12m-15m':
                return $price >= 12000000 && $price <= 15000000;
            case 'more-15m':
                return $price > 15000000;
            default:
                return true;
        }
    }

    /**
     * Check if laptop RAM is suitable for user activities
     */
    private function checkRamMatch($laptopRam, $userActivities)
    {
        $ramValue = (int) filter_var($laptopRam, FILTER_SANITIZE_NUMBER_INT);
        $activities = json_decode($userActivities, true);

        $minRamRequired = 4; // Default minimum

        foreach ($activities as $activity) {
            switch ($activity) {
                case 'machine-learning':
                case 'game-dev':
                    $minRamRequired = max($minRamRequired, 16);
                    break;
                case 'programming':
                case 'desain':
                    $minRamRequired = max($minRamRequired, 8);
                    break;
                case 'database':
                case 'network':
                    $minRamRequired = max($minRamRequired, 8);
                    break;
            }
        }

        return $ramValue >= $minRamRequired;
    }

    /**
     * Check if laptop GPU is suitable for user activities
     */
    private function checkGpuMatch($laptopGpu, $userActivities)
    {
        $activities = json_decode($userActivities, true);
        $needsDedicatedGpu = false;

        foreach ($activities as $activity) {
            if (in_array($activity, ['machine-learning', 'game-dev', 'desain'])) {
                $needsDedicatedGpu = true;
                break;
            }
        }

        if (!$needsDedicatedGpu) {
            return true; // Any GPU is fine
        }

        // Check if laptop has dedicated GPU
        $dedicatedGpus = ['GTX', 'RTX', 'RX ', 'Radeon RX'];
        foreach ($dedicatedGpus as $gpu) {
            if (strpos($laptopGpu, $gpu) !== false) {
                return true;
            }
        }

        return false; // Needs dedicated GPU but doesn't have one
    }

    /**
     * Check if screen size matches user preference
     */
    private function checkScreenMatch($laptopScreen, $userScreenPref)
    {
        $screenSize = (float) filter_var($laptopScreen, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

        switch ($userScreenPref) {
            case '13-14-inch':
                return $screenSize >= 13 && $screenSize <= 14;
            case '15-16-inch':
                return $screenSize >= 15 && $screenSize <= 16;
            case '17-inch':
                return $screenSize >= 17;
            case 'high-res':
                return true; // Any size with high resolution preference
            default:
                return true;
        }
    }

    /**
     * Calculate preference bonus based on exact matches
     */
    private function calculatePreferenceBonus($laptop, $userResponse)
    {
        $bonus = 0;
        $activities = json_decode($userResponse->activities, true);

        // Activity-based bonuses
        foreach ($activities as $activity) {
            switch ($activity) {
                case 'programming':
                    if (strpos($laptop->processor, 'i5') !== false || strpos($laptop->processor, 'Ryzen 5') !== false) {
                        $bonus += 0.05;
                    }
                    break;
                case 'machine-learning':
                    if (strpos($laptop->gpu, 'RTX') !== false) {
                        $bonus += 0.1;
                    }
                    break;
                case 'game-dev':
                    if (strpos($laptop->gpu, 'GTX') !== false || strpos($laptop->gpu, 'RTX') !== false) {
                        $bonus += 0.08;
                    }
                    break;
            }
        }

        // Storage type bonus
        if ($userResponse->storage === 'ssd-1tb' && strpos($laptop->storage, 'SSD') !== false) {
            $bonus += 0.03;
        }

        return min($bonus, 0.2); // Cap bonus at 0.2
    }
}