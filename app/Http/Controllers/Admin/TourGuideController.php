<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TourGuide;
use Illuminate\Http\Request;
use App\Models\Permit;

class TourGuideController extends Controller
{
    /**
     * Display a listing of the resource (All Guides).
     */
    public function index()
    {
        $guides = TourGuide::orderBy('name')->get();
        return view('admin.guides.index', compact('guides'));
    }

    /**
     * Show the form for creating a new resource (Add Guide).
     */
    public function create()
    {
        return view('admin.guides.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'license_id' => 'required|string|max:50|unique:tour_guides,license_id',
            'is_active' => 'nullable|boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active'); // Convert checkbox to boolean

        TourGuide::create($validatedData);

        return redirect()->route('admin.guides.index')
                         ->with('success', 'Tour Guide added successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TourGuide $guide)
    {
        return view('admin.guides.edit', compact('guide'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TourGuide $guide)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email|unique:guides',
            'nid_number' => 'required|unique:guides',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'license_id' => 'required|string|max:50|unique:tour_guides,license_id,' . $guide->id,
            'is_active' => 'nullable|boolean',
        ]);

        $validatedData['is_active'] = $request->has('is_active');

        $guide->update($validatedData);

        return redirect()->route('admin.guides.index')
                         ->with('success', 'Tour Guide updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TourGuide $guide)
    {
        // NOTE: In a real application, you should check if this guide is 
        // linked to any active permits before deleting.
        $guide->delete();

        return redirect()->route('admin.guides.index')
                         ->with('success', 'Tour Guide deleted successfully!');
    }

    public function listPermits()
{
    // Eager load relationships to prevent slow loading
    $permits = Permit::with(['tourGuide', 'teamMembers'])->latest()->get();
    
    return view('admin.permit.index', compact('permits'));
}


}