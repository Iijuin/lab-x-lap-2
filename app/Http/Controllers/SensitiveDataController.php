<?php

namespace App\Http\Controllers;

use App\Models\SensitiveData;
use Illuminate\Http\Request;

class SensitiveDataController extends Controller
{
    public function index()
    {
        $data = SensitiveData::all();
        return view('sensitive-data.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'address' => 'required|string'
        ]);

        SensitiveData::create($validated);

        return redirect()->route('sensitive-data.index')
            ->with('success', 'Data berhasil disimpan dengan aman');
    }
} 