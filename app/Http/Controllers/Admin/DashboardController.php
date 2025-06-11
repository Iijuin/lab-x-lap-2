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
        // Jika user belum login, tampilkan halaman login required
        if (!auth()->check()) {
            return view('admin.login_required');
        }

        // Jika user bukan admin, redirect ke home
        if (!auth()->user()->is_admin) {
            return redirect()->route('home')->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        // Jika user adalah admin, tampilkan dashboard
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