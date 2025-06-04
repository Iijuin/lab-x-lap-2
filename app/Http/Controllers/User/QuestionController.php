<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserResponse;
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
    // Debug logging
    Log::info('Store method called', [
        'method' => $request->method(),
        'url' => $request->url(),
        'content_type' => $request->header('Content-Type'),
        'expects_json' => $request->expectsJson(),
        'data' => $request->all()
    ]);

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

        Log::info('Validation passed', ['validated_data' => $validatedData]);

        // Save data to database
        $userResponse = UserResponse::create([
            'name' => $validatedData['name'],
            'program' => $validatedData['program'],
            'activities' => json_encode($validatedData['activities']),
            'budget' => $validatedData['budget'],
            'ram' => $validatedData['ram'],
            'storage' => $validatedData['storage'],
            'gpu' => $validatedData['gpu'],
            'screen' => $validatedData['screen'],
        ]);

        // Log successful submission
        Log::info('User response saved successfully', [
            'user_response_id' => $userResponse->id,
            'name' => $validatedData['name']
        ]);

        // Check if request expects JSON (AJAX) or regular form submission
        if ($request->expectsJson() || $request->ajax()) {
            // Return JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan!',
                'data' => $userResponse,
                'redirect_url' => route('results.show', $userResponse->id)
            ]);
        } else {
            // Regular form submission - redirect directly
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
        } else {
            return redirect()->back()
                           ->withErrors($e->errors())
                           ->withInput();
        }

    } catch (\Exception $e) {
        // Log the error
        Log::error('Error saving user response', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()
            ], 500);
        } else {
            return redirect()->back()
                           ->with('error', 'Terjadi kesalahan saat menyimpan data.')
                           ->withInput();
        }
    }
}

    /**
     * Get form options for dynamic loading (optional)
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
                'hdd-500gb' => 'HDD 500 GB',
                'hdd-1tb' => 'HDD 1 TB',
                'ssd-256gb' => 'SSD 256 GB',
                'ssd-1tb' => 'SSD 1 TB (atau Lebih)'
            ],
            'gpu_options' => [
                'no-gpu' => 'Tidak memerlukan GPU khusus',
                'integrated' => 'GPU integrasi terbaru',
                'entry-level' => 'GPU entry level (NVIDIA GTX 1650/AMD Setara)',
                'mid-range' => 'GPU mid-range (NVIDIA RTX 3050/AMD setara)',
                'high-end' => 'GPU high-end (NVIDIA RTX 3060/AMD setara)'
            ],
            'screen_options' => [
                '13-14-inch' => '13-14 inch (compact)',
                '15-16-inch' => '15-16 inch (standard)',
                '17-inch' => '17 inch (desktop replacement)',
                'high-res' => 'High Resolution (1440p/4K)'
            ]
        ]);
    }
}