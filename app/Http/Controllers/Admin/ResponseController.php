<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UserResponse;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = UserResponse::with('user')
            ->latest()
            ->paginate(10);
            
        return view('admin.responses.index', compact('responses'));
    }

    public function show(UserResponse $response)
    {
        $response->load(['user', 'recommendations.laptop']);
        return view('admin.responses.show', compact('response'));
    }
} 