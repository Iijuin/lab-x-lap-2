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

        // Add formatted price and budget to each laptop
        $scoredLaptops->each(function ($laptop) use ($userResponse) {
            $laptop->formatted_price = $this->formatRupiah($laptop->price);
            $laptop->formatted_budget = $this->formatBudgetRange($userResponse->budget);
        });

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
            
            // Calculate weighted score with sub-criteria
            $totalScore = 0;
            foreach ($weights as $criterion => $weight) {
                if (isset($scores[$criterion])) {
                    // Processor sub-criteria
                    if ($criterion === 'processor') {
                        $processorScore = $this->calculateProcessorScore($laptop->processor, $userResponse->activities);
                        $totalScore += $processorScore * $weight;
                    }
                    // RAM sub-criteria
                    else if ($criterion === 'ram') {
                        $ramScore = $this->calculateRamScore($laptop->ram, $userResponse->activities);
                        $totalScore += $ramScore * $weight;
                    }
                    // Storage sub-criteria
                    else if ($criterion === 'storage') {
                        $storageScore = $this->calculateStorageScore($laptop->storage, $userResponse->storage);
                        $totalScore += $storageScore * $weight;
                    }
                    // GPU sub-criteria
                    else if ($criterion === 'gpu') {
                        $gpuScore = $this->calculateGpuScore($laptop->gpu, $userResponse->activities);
                        $totalScore += $gpuScore * $weight;
                    }
                    // Screen sub-criteria
                    else if ($criterion === 'screen') {
                        $screenScore = $this->calculateScreenScore($laptop->screen_size, $userResponse->screen);
                        $totalScore += $screenScore * $weight;
                    }
                    // Price sub-criteria
                    else if ($criterion === 'price') {
                        $priceScore = $this->calculatePriceScore($laptop->price, $userResponse->budget);
                        $totalScore += $priceScore * $weight;
                    }
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

    // Processor scoring
    private function calculateProcessorScore($processor, $activities)
    {
        $score = 0;
        $activities = json_decode($activities, true);
        
        // Check processor generation
        if (preg_match('/i[3579]|Ryzen [3579]/', $processor)) {
            $score += 0.4;
        }
        
        // Check for specific activities
        foreach ($activities as $activity) {
            switch ($activity) {
                case 'machine-learning':
                    if (strpos($processor, 'i7') !== false || strpos($processor, 'i9') !== false || 
                        strpos($processor, 'Ryzen 7') !== false || strpos($processor, 'Ryzen 9') !== false) {
                        $score += 0.3;
                    }
                    break;
                case 'programming':
                    if (strpos($processor, 'i5') !== false || strpos($processor, 'Ryzen 5') !== false) {
                        $score += 0.2;
                    }
                    break;
            }
        }
        
        return min($score, 1.0);
    }

    // RAM scoring
    private function calculateRamScore($ram, $activities)
    {
        $score = 0;
        $ramValue = (int) filter_var($ram, FILTER_SANITIZE_NUMBER_INT);
        $activities = json_decode($activities, true);
        
        // Base score based on RAM capacity
        if ($ramValue >= 32) $score += 0.4;
        else if ($ramValue >= 16) $score += 0.3;
        else if ($ramValue >= 8) $score += 0.2;
        else if ($ramValue >= 4) $score += 0.1;
        
        // Activity-based scoring
        foreach ($activities as $activity) {
            if (in_array($activity, ['machine-learning', 'game-dev']) && $ramValue >= 16) {
                $score += 0.3;
            }
            if (in_array($activity, ['programming', 'desain']) && $ramValue >= 8) {
                $score += 0.2;
            }
        }
        
        return min($score, 1.0);
    }

    // Storage scoring
    private function calculateStorageScore($storage, $userStorage)
    {
        $score = 0;
        
        // Check storage type
        if (strpos($storage, 'SSD') !== false) {
            $score += 0.4;
        } else if (strpos($storage, 'HDD') !== false) {
            $score += 0.2;
        }
        
        // Check storage capacity
        $capacity = (int) filter_var($storage, FILTER_SANITIZE_NUMBER_INT);
        if ($capacity >= 1000) $score += 0.3;
        else if ($capacity >= 512) $score += 0.2;
        else if ($capacity >= 256) $score += 0.1;
        
        // Match user preference
        if ($userStorage === 'ssd-1tb' && strpos($storage, 'SSD') !== false && $capacity >= 1000) {
            $score += 0.3;
        }
        
        return min($score, 1.0);
    }

    // GPU scoring
    private function calculateGpuScore($gpu, $activities)
    {
        $score = 0;
        $activities = json_decode($activities, true);
        
        // Check GPU type
        if (strpos($gpu, 'RTX') !== false) {
            $score += 0.4;
        } else if (strpos($gpu, 'GTX') !== false) {
            $score += 0.3;
        } else if (strpos($gpu, 'MX') !== false) {
            $score += 0.2;
        } else if (strpos($gpu, 'Radeon') !== false) {
            $score += 0.25;
        }
        
        // Activity-based scoring
        foreach ($activities as $activity) {
            if (in_array($activity, ['machine-learning', 'game-dev', 'desain'])) {
                if (strpos($gpu, 'RTX') !== false) {
                    $score += 0.3;
                } else if (strpos($gpu, 'GTX') !== false) {
                    $score += 0.2;
                }
            }
        }
        
        return min($score, 1.0);
    }

    // Screen scoring
    private function calculateScreenScore($screenSize, $userScreen)
    {
        $score = 0;
        $size = (float) filter_var($screenSize, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        
        // Size-based scoring
        if ($size >= 17) $score += 0.3;
        else if ($size >= 15) $score += 0.2;
        else if ($size >= 13) $score += 0.1;
        
        // Match user preference
        switch ($userScreen) {
            case '13-14-inch':
                if ($size >= 13 && $size <= 14) $score += 0.4;
                break;
            case '15-16-inch':
                if ($size >= 15 && $size <= 16) $score += 0.4;
                break;
            case '17-inch':
                if ($size >= 17) $score += 0.4;
                break;
        }
        
        return min($score, 1.0);
    }

    /**
     * Format number to Rupiah currency
     */
    private function formatRupiah($number)
    {
        return 'Rp ' . number_format($number, 0, ',', '.');
    }

    // Price scoring
    private function calculatePriceScore($price, $budget)
    {
        $score = 0;
        
        // Format price ranges for better readability
        $ranges = [
            'less-5m' => [
                'min' => 0,
                'max' => 5000000,
                'next' => 6000000
            ],
            '5m-8m' => [
                'min' => 5000000,
                'max' => 8000000,
                'next' => 9000000
            ],
            '8m-12m' => [
                'min' => 8000000,
                'max' => 12000000,
                'next' => 13000000
            ],
            '12m-15m' => [
                'min' => 12000000,
                'max' => 15000000,
                'next' => 16000000
            ],
            'more-15m' => [
                'min' => 15000000,
                'max' => PHP_FLOAT_MAX,
                'next' => 14000000
            ]
        ];

        if (isset($ranges[$budget])) {
            $range = $ranges[$budget];
            
            if ($price >= $range['min'] && $price <= $range['max']) {
                $score = 1.0;
            } else if ($price < $range['next']) {
                $score = 0.7;
            } else {
                $score = 0.3;
            }
        }
        
        return $score;
    }

    /**
     * Format budget range to readable format
     */
    private function formatBudgetRange($budget)
    {
        $ranges = [
            'less-5m' => 'Di bawah ' . $this->formatRupiah(5000000),
            '5m-8m' => $this->formatRupiah(5000000) . ' - ' . $this->formatRupiah(8000000),
            '8m-12m' => $this->formatRupiah(8000000) . ' - ' . $this->formatRupiah(12000000),
            '12m-15m' => $this->formatRupiah(12000000) . ' - ' . $this->formatRupiah(15000000),
            'more-15m' => 'Di atas ' . $this->formatRupiah(15000000)
        ];

        return $ranges[$budget] ?? $budget;
    }
}