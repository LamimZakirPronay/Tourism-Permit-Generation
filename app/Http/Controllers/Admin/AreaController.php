<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area; // This tells the controller where the Area model is
use Illuminate\Http\Request;

class AreaController extends Controller
{
    /**
     * Display a listing of the areas.
     */
    public function index()
    {
        $areas = Area::orderBy('name', 'asc')->get();
        return view('admin.areas.index', compact('areas'));
    }

    /**
     * Store a newly created area in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:areas,name|max:255',
        ]);

        Area::create([
            'name' => $request->name,
            'is_active' => true,
        ]);

        return back()->with('success', 'Restricted Area added successfully!');
    }

    /**
     * Remove the specified area from storage.
     */
    public function destroy(Area $area)
    {
        $area->delete();
        return back()->with('success', 'Area deleted successfully!');
    }
}