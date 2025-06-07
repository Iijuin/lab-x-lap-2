<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Criteria;

class CriteriaController extends Controller
{
    public function index()
    {
        $criteria = Criteria::latest()->paginate(10);
        return view('admin.criteria.index', compact('criteria'));
    }

    public function create()
    {
        return view('admin.criteria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0|max:1',
        ]);

        Criteria::create($validated);

        return redirect()->route('admin.criteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan');
    }

    public function edit(Criteria $criteria)
    {
        return view('admin.criteria.edit', compact('criteria'));
    }

    public function update(Request $request, Criteria $criteria)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'weight' => 'required|numeric|min:0|max:1',
        ]);

        $criteria->update($validated);

        return redirect()->route('admin.criteria.index')
            ->with('success', 'Kriteria berhasil diperbarui');
    }

    public function destroy(Criteria $criteria)
    {
        $criteria->delete();
        return redirect()->route('admin.criteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }

    public function confirmDelete(Criteria $criteria)
    {
        return view('admin.criteria.delete', compact('criteria'));
    }
}
