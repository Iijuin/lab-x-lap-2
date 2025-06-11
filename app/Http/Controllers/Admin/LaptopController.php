<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laptop;
use Illuminate\Support\Facades\Storage;

class LaptopController extends Controller
{
    public function index()
    {
        $laptops = Laptop::latest()->paginate(10);
        return view('admin.laptops.index', compact('laptops'));
    }

    public function create()
    {
        return view('admin.laptops.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'processor' => 'required|string|max:255',
            'ram' => 'required|string|max:50',
            'storage' => 'required|string|max:255',
            'gpu' => 'required|string|max:255',
            'screen_size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if (isset($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }
            
            // Upload gambar baru
            $imagePath = $request->file('image')->store('laptops', 'public');
            $validated['image'] = $imagePath;
        }

        Laptop::create($validated);

        return redirect()->route('admin.laptops.index')
            ->with('success', 'Laptop berhasil ditambahkan');
    }

    public function edit(Laptop $laptop)
    {
        return view('admin.laptops.edit', compact('laptop'));
    }

    public function update(Request $request, Laptop $laptop)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'processor' => 'required|string|max:255',
            'ram' => 'required|string|max:50',
            'storage' => 'required|string|max:255',
            'gpu' => 'required|string|max:255',
            'screen_size' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($laptop->image) {
                Storage::disk('public')->delete($laptop->image);
            }
            
            // Upload gambar baru
            $imagePath = $request->file('image')->store('laptops', 'public');
            $validated['image'] = $imagePath;
        }

        $laptop->update($validated);

        return redirect()->route('admin.laptops.index')
            ->with('success', 'Laptop berhasil diperbarui');
    }

    public function toggleStatus(Laptop $laptop)
    {
        $laptop->is_active = !$laptop->is_active;
        $laptop->save();

        $status = $laptop->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.laptops.index')
            ->with('success', "Laptop berhasil {$status}");
    }
}
