<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permit;
use App\Models\TourGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TourGuideController extends Controller
{
    public function index()
    {
        $guides = TourGuide::orderBy('name')->get();

        return view('admin.guides.index', compact('guides'));
    }

    public function create()
    {
        return view('admin.guides.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:5',
            'marital_status' => 'nullable|string',
            'spouse_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:tour_guides,email',
            'contact' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'license_id' => 'required|string|max:50|unique:tour_guides,license_id',
            'nid_number' => 'required|string|max:50|unique:tour_guides,nid_number',
            'address' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->hasFile('attachment')) {
            $validatedData['attachment_path'] = $request->file('attachment')->store('guides/attachments', 'public');
        }

        $validatedData['is_active'] = $request->has('is_active');

        TourGuide::create($validatedData);

        return redirect()->route('admin.guides.index')->with('success', 'Tour Guide added successfully!');
    }

    public function edit(TourGuide $guide)
    {
        return view('admin.guides.edit', compact('guide'));
    }

    public function update(Request $request, TourGuide $guide)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'parent_name' => 'nullable|string|max:255',
            'blood_group' => 'nullable|string|max:10',
            'marital_status' => 'nullable|string',
            'spouse_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:tour_guides,email,'.$guide->id,
            'contact' => 'required|string|max:20',
            'emergency_contact' => 'nullable|string|max:20',
            'license_id' => 'required|string|max:50|unique:tour_guides,license_id,'.$guide->id,
            'nid_number' => 'required|string|max:50|unique:tour_guides,nid_number,'.$guide->id,
            'address' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'is_active' => 'nullable',
        ]);

        // Handle File Upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($guide->attachment_path) {
                Storage::disk('public')->delete($guide->attachment_path);
            }
            $validatedData['attachment_path'] = $request->file('attachment')->store('guides/attachments', 'public');
        }

        $validatedData['is_active'] = $request->has('is_active');

        $guide->update($validatedData);

        return redirect()->route('admin.guides.index')->with('success', 'Tour Guide updated successfully!');
    }

    public function destroy(TourGuide $guide)
    {
        try {
            // 1. Delete the attachment from storage if it exists
            if ($guide->attachment_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($guide->attachment_path);
            }

            // 2. Attempt to delete the record
            $guide->delete();

            return redirect()->route('admin.guides.index')
                ->with('success', 'Tour Guide deleted successfully!');

        } catch (\Illuminate\Database\QueryException $e) {
            // 3. Handle Foreign Key Constraint errors (if guide is used in a permit)
            return redirect()->route('admin.guides.index')
                ->with('error', 'Unable to delete: This guide is associated with existing permits.');
        }
    }

    public function listPermits()
    {
        $permits = Permit::with(['tourGuide', 'teamMembers'])->latest()->get();

        return view('admin.permit.index', compact('permits'));
    }
}
