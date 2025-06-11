<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserResponse;
use App\Models\Laptop;
use App\Models\LaptopRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    /**
     * Display the questionnaire form
     */
    public function index()
    {
        return view('user.questions.index');
    }

    /**
     * Store questionnaire data
     */
    public function store(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'program' => 'required|string|in:Teknik Informatika,Teknik Multimedia Digital,Teknik Multimedia Jaringan',
                'activities' => 'required|array|min:1',
                'activities.*' => 'string|in:programming,desain,machine-learning,game-dev,office,network,database',
                'budget' => 'required|string|in:less-5m,5m-8m,8m-12m,12m-15m,more-15m',
                'ram' => 'required|string|in:4gb,8gb,16gb,32gb',
                'storage' => 'required|string|in:hdd-500gb,hdd-1tb,ssd-256gb,ssd-1tb',
                'gpu' => 'required|string|in:no-gpu,integrated,entry-level,mid-range,high-end',
                'screen' => 'required|string|in:13-14-inch,15-16-inch,17-inch,high-res',
            ]);

            // Save data to database
            $userResponse = UserResponse::create([
                'name' => $validatedData['name'],
                'program' => $validatedData['program'],
                'activities' => json_encode($validatedData['activities']),
                'budget' => $validatedData['budget'],
                'ram' => $validatedData['ram'],
                'storage' => $validatedData['storage'],
                'gpu' => $validatedData['gpu'],
                'screen' => $validatedData['screen']
            ]);

            // Generate and save recommendations
            $recommendations = $this->generateRecommendations($userResponse);
            foreach ($recommendations as $laptop) {
                LaptopRecommendation::create([
                    'user_response_id' => $userResponse->id,
                    'laptop_id' => $laptop->id,
                    'score' => $laptop->score
                ]);
            }

            // Log minimal information
            Log::info('User response saved', [
                'user_response_id' => $userResponse->id
            ]);

            // Return minimal data in response
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil disimpan!',
                    'redirect_url' => route('results.show', $userResponse->id)
                ]);
            } else {
                return redirect()->route('results.show', $userResponse->id)
                               ->with('success', 'Rekomendasi laptop berhasil dibuat!');
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed', ['errors' => $e->errors()]);
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak valid',
                    'errors' => $e->errors()
                ], 422);
            }
            
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();

        } catch (\Exception $e) {
            Log::error('Error saving user response', [
                'error' => $e->getMessage()
            ]);

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan saat menyimpan data'
                ], 500);
            } else {
                return redirect()->back()
                               ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                               ->withInput();
            }
        }
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
            
            // Include laptop even if score is 0, but with lower priority
            $laptop->score = $score;
            $recommendations[] = $laptop;
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
        $activities = is_array($userResponse->activities)
            ? $userResponse->activities
            : json_decode($userResponse->activities, true);
        $activityScore = 0;
        
        foreach ($activities as $activity) {
            switch ($activity) {
                case 'programming':
                    if (stripos($laptop->processor, 'i5') !== false || 
                        stripos($laptop->processor, 'ryzen 5') !== false) {
                        $activityScore += 10;
                    }
                    if (stripos($laptop->processor, 'i7') !== false || 
                        stripos($laptop->processor, 'ryzen 7') !== false) {
                        $activityScore += 5;
                    }
                    break;
                    
                case 'machine-learning':
                    if (stripos($laptop->processor, 'i7') !== false || 
                        stripos($laptop->processor, 'ryzen 7') !== false) {
                        $activityScore += 10;
                    }
                    if (stripos($laptop->gpu, 'rtx') !== false) {
                        $activityScore += 10;
                    }
                    break;
                    
                case 'game-dev':
                    if (stripos($laptop->gpu, 'rtx') !== false) {
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

        return min($score, $maxScore) / 100; // Convert to 0-1 scale
    }

    /**
     * Get form options for dynamic loading
     */
    public function getFormOptions()
    {
        return response()->json([
            'programs' => [
                'Teknik Informatika',
                'Teknik Multimedia Digital',
                'Teknik Multimedia Jaringan'
            ],
            'activities' => [
                'programming' => 'Programming/Coding',
                'desain' => 'Desain Grafis/Multimedia',
                'machine-learning' => 'Machine Learning/AI',
                'game-dev' => 'Pengembangan Game',
                'office' => 'Office/Produktivitas',
                'network' => 'Network Configurating',
                'database' => 'Database'
            ],
            'budget_ranges' => [
                'less-5m' => '< Rp5.000.000',
                '5m-8m' => 'Rp5.000.000 - 8.000.000',
                '8m-12m' => 'Rp8.000.000 - 12.000.000',
                '12m-15m' => 'Rp12.000.000 - 15.000.000',
                'more-15m' => '>Rp15.000.000'
            ],
            'ram_options' => [
                '4gb' => '4 GB',
                '8gb' => '8 GB',
                '16gb' => '16 GB',
                '32gb' => '32 GB/Lebih'
            ],
            'storage_options' => [
                'hdd-500gb' => 'HDD 500GB',
                'hdd-1tb' => 'HDD 1TB',
                'ssd-256gb' => 'SSD 256GB',
                'ssd-1tb' => 'SSD 1TB'
            ],
            'gpu_options' => [
                'no-gpu' => 'Tidak ada GPU',
                'integrated' => 'GPU Terintegrasi',
                'entry-level' => 'GPU Entry Level',
                'mid-range' => 'GPU Mid Range',
                'high-end' => 'GPU High End'
            ],
            'screen_options' => [
                '13-14-inch' => '13-14 inch',
                '15-16-inch' => '15-16 inch',
                '17-inch' => '17 inch',
                'high-res' => 'High Resolution'
            ]
        ]);
    }
}