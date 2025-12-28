<?php

namespace App\Http\Controllers\admin;

use App\Models\Size;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    public function index()
    {
        try {
            $sizes = Size::latest()->get();
            $colors = Color::latest()->get();

            $editColor = request()->query('edit_color_id') ? Color::findOrFail(request()->query('edit_color_id')) : null;
            $editSize = request()->query('edit_size_id') ? Size::findOrFail(request()->query('edit_size_id')) : null;

            return view('admin.sizes_colors.index', compact('sizes', 'colors', 'editColor', 'editSize'));
        } catch (\Exception $e) {
            Log::error('Error loading sizes & colors index: ' . $e->getMessage());

            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred while loading size & color management.');
        }
    }

    // ================= COLOR =================
    public function storeColor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Color::create([
                'name' => $request->name,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('sizes_colors.index')->with('success', 'Color created successfully.');
        } catch (\Exception $e) {
            Log::error('Color creation error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while creating color.');
        }
    }

    public function updateColor(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $color = Color::findOrFail($id);
            $color->update(['name' => $request->name]);

            return redirect()->route('sizes_colors.index')->with('success', 'Color updated successfully.');
        } catch (\Exception $e) {
            Log::error('Color update error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while updating color.');
        }
    }

    public function updateColorStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:a,d',
        ]);

        try {
            $color = Color::findOrFail($id);
            $color->update(['status' => $request->status]);

            return back()->with('success', 'Color status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Color status update error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while updating status.');
        }
    }

    public function destroyColor($id)
    {
        try {
            $color = Color::findOrFail($id);
            $color->delete();

            return redirect()->route('sizes_colors.index')->with('success', 'Color deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Color delete error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while deleting color.');
        }
    }

    // ================= SIZE =================
    public function storeSize(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Size::create([
                'name' => $request->name,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('sizes_colors.index')->with('success', 'Size created successfully.');
        } catch (\Exception $e) {
            Log::error('Size creation error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while creating size.');
        }
    }

    public function updateSize(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $size = Size::findOrFail($id);
            $size->update(['name' => $request->name]);

            return redirect()->route('sizes_colors.index')->with('success', 'Size updated successfully.');
        } catch (\Exception $e) {
            Log::error('Size update error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while updating size.');
        }
    }

    public function updateSizeStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:a,d',
        ]);

        try {
            $size = Size::findOrFail($id);
            $size->update(['status' => $request->status]);

            return back()->with('success', 'Size status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Size status update error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while updating status.');
        }
    }

    public function destroySize($id)
    {
        try {
            $size = Size::findOrFail($id);
            $size->delete();

            return redirect()->route('sizes_colors.index')->with('success', 'Size deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Size delete error: ' . $e->getMessage());
            return back()->with('error', 'Error occurred while deleting size.');
        }
    }
}
