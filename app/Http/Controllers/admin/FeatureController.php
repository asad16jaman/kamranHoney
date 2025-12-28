<?php

namespace App\Http\Controllers\admin;

use App\Models\Feature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FeatureController extends Controller
{
    public function index()
    {
        try {
            $features = Feature::latest()->get();
            return view('admin.features.index', compact('features'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the features index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }


    public function create(?Feature $feature = null)
    {
        try {
            $features = Feature::latest()->get();
            return view('admin.features.create', compact('features', 'feature'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the feature create page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'features_title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        try {
            $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                ($request->file('image')
                    ? $request->file('image')->getClientOriginalExtension()
                    : '');

            $imagePath = 'uploads/features/' . $imageName;

            if ($request->hasFile('image')) {
                $request->file('image')->move(public_path('uploads/features'), $imageName);
            } else {
                $imagePath = 'uploads/no_images/no-image.png';
                $imageName = 'no-image.png';
            }

            Feature::create([
                'features_title' => $request->input('features_title'),
                'image' => $imageName,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return back()->with('success', 'Feature created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while creating the feature: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the feature. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $feature = Feature::findOrFail($id);
            $features = Feature::latest()->get();
            return view('admin.features.create', compact('feature', 'features'));
        } catch (\Exception $e) {
            Log::error('Error occurred while retrieving the feature for editing: ' . $e->getMessage());
            return redirect()->route('features.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $request->validate([
            'features_title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ]);

        try {
            $feature = Feature::findOrFail($id);

            $imageName = $feature->image;

            if ($request->hasFile('image')) {
                $newImageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                    $request->file('image')->getClientOriginalExtension();

                $newImagePath = 'uploads/features/' . $newImageName;

                $request->file('image')->move(public_path('uploads/features'), $newImageName);

                if ($feature->image && $feature->image !== 'no-image.png') {
                    $oldImagePath = public_path('uploads/features/' . $feature->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $imageName = $newImageName;
            }

            $feature->update([
                'features_title' => $request->input('features_title'),
                'image' => $imageName,
            ]);

            DB::commit();

            return redirect()->route('features.create')->with('success', 'Feature updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while updating the feature: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the feature. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $feature = Feature::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $feature->status = $request->status;
            $feature->save();

            return back()->with('success', 'Feature status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating feature status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $feature = Feature::findOrFail($id);

            if ($feature->image && $feature->image !== 'no-image.png') {
                $imagePath = public_path('uploads/features/' . $feature->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $feature->delete();

            return redirect()->back()->with('success', 'Feature deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting feature with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
