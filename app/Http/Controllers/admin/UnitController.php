<?php

namespace App\Http\Controllers\Admin;

use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UnitController extends Controller
{
    public function index()
    {
        try {
            $units = Unit::latest()->get();
            return view('admin.units.index', compact('units'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the units index page: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Unit $unit = null)
    {
        try {
            $units = Unit::latest()->get();
            return view('admin.units.create', compact('units', 'unit'));
        } catch (\Exception $e) {
            Log::error('Error displaying create unit page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create unit page. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {

            Unit::create([
                'name' => $request->name,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('unit.create')->with('success', 'Unit created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating unit: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the unit. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $unit = Unit::findOrFail($id);
            $units = Unit::latest()->get();
            return view('admin.units.create', compact('unit', 'units'));
        } catch (\Exception $e) {
            Log::error('Error fetching unit for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the unit. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $unit = Unit::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $unit->update([
                'name' => $request->name,
            ]);

            return redirect()->route('unit.create')->with('success', 'Unit updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating unit: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the unit. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $unit = Unit::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $unit->status = $request->status;
            $unit->save();

            return back()->with('success', 'Unit status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating user status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $unit = Unit::findOrFail($id);

            $unit->delete();

            return redirect()->route('unit.create')->with('success', 'Unit deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting unit with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('unit.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    } 
}
