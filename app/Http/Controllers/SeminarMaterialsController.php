<?php

namespace App\Http\Controllers;

use App\Models\SeminarMaterial;
use App\Models\SeminarMaterials;
use Illuminate\Http\Request;

class SeminarMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $seminarMaterials = SeminarMaterials::all();
        return view('seminar_materials.index', compact('seminarMaterials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seminar_materials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        SeminarMaterials::create($request->all());

        return redirect()->route('seminar_materials.index')
                         ->with('success', 'Seminar material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SeminarMaterials $seminarMaterial)
    {
        return view('seminar_materials.show', compact('seminarMaterial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SeminarMaterials $seminarMaterial)
    {
        return view('seminar_materials.edit', compact('seminarMaterial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SeminarMaterials $seminarMaterial)
    {
        $request->validate([
            'file_path' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);

        $seminarMaterial->update($request->all());

        return redirect()->route('seminar_materials.index')
                         ->with('success', 'Seminar material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SeminarMaterials $seminarMaterial)
    {
        $seminarMaterial->delete();

        return redirect()->route('seminar_materials.index')
                         ->with('success', 'Seminar material deleted successfully.');
    }
}
