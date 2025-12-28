<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Size;

class SizeController extends Controller
{
    public function index()
    {
        try {
            $sizes = Size::latest()->get();
            return view('admin.sizes.index', compact('sizes'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the sizes index page: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Size $size = null)
    {
        try {
            $sizes = Size::latest()->get();
            return view('admin.sizes.create', compact('sizes', 'size'));
        } catch (\Exception $e) {
            Log::error('Error displaying create size page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create size page. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            Size::create([
                'name' => $request->name,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('sizes.create')->with('success', 'Size created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating size: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the size. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $size = Size::findOrFail($id);
            $sizes = Size::latest()->get();
            return view('admin.sizes.create', compact('size', 'sizes'));
        } catch (\Exception $e) {
            Log::error('Error fetching size for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the size. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $size = Size::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
            ]);

            $size->update([
                'name' => $request->name,
            ]);

            return redirect()->route('sizes.create')->with('success', 'Size updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating size: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the size. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $size = Size::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $size->status = $request->status;
            $size->save();

            return back()->with('success', 'Size status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating size status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $size = Size::findOrFail($id);
            $size->delete();

            return redirect()->route('sizes.create')->with('success', 'Size deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting size with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('sizes.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
