<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laptop;
use App\Models\UserResponse;
use App\Models\Criteria;

class DashboardController extends Controller
{
    public function index()
    {
        $totalLaptops = Laptop::count();
        $totalResponses = UserResponse::count();
        $totalCriteria = Criteria::count();
        
        $recentResponses = UserResponse::with('user')
            ->latest()
            ->take(5)
            ->get();
            
        $laptopStats = [
            'total' => $totalLaptops,
            'byPrice' => [
                'low' => Laptop::where('price', '<', 10000000)->count(),
                'medium' => Laptop::whereBetween('price', [10000000, 15000000])->count(),
                'high' => Laptop::where('price', '>', 15000000)->count(),
            ]
        ];
        
        return view('admin.dashboard', compact(
            'totalLaptops',
            'totalResponses',
            'totalCriteria',
            'recentResponses',
            'laptopStats'
        ));
    }
} 