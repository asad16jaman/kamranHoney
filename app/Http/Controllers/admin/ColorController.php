<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        try {
            $colors = Color::latest()->get();
            return view('admin.colors.index', compact('colors'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the colors index page: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Color $color = null)
    {
        try {
            $colors = Color::latest()->get();
            return view('admin.colors.create', compact('colors', 'color'));
        } catch (\Exception $e) {
            Log::error('Error displaying create color page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create color page. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Color::create([
                'name' => $request->name,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('colors.create')->with('success', 'Color created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating color: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the color. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $color = Color::findOrFail($id);
            $colors = Color::latest()->get();
            return view('admin.colors.create', compact('color', 'colors'));
        } catch (\Exception $e) {
            Log::error('Error fetching color for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the color. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $color = Color::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $color->update([
                'name' => $request->name,
            ]);

            return redirect()->route('colors.create')->with('success', 'Color updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating color: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the color. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $color = Color::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $color->status = $request->status;
            $color->save();

            return back()->with('success', 'Color status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating color status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();

            return redirect()->route('colors.create')->with('success', 'Color deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting color with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('colors.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
