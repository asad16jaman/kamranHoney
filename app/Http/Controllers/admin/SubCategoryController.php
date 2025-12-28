<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class SubCategoryController extends Controller
{
    public function index()
    {
        try {
            $subCategories = SubCategory::with('category')->latest()->get();
            return view('admin.subcategories.index', compact('subCategories'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the subcategories index page: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?SubCategory $subCategory = null)
    {
        try {
            $categories = Category::latest()->get();
            $subCategories = SubCategory::with('category')->latest()->get();
            return view('admin.subcategories.create', compact('categories', 'subCategory', 'subCategories'));
        } catch (\Exception $e) {
            Log::error('Error displaying create subcategory page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create subcategory page. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $imagePath = 'uploads/no_images/no-image.png';

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/subcategory'), $imageName);
                $imagePath = 'uploads/subcategory/' . $imageName;
            }

            SubCategory::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('subcategories.create')->with('success', 'Subcategory created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating subcategory: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the subcategory. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $subCategory = SubCategory::findOrFail($id);
            $categories = Category::latest()->get();
            $subCategories = SubCategory::with('category')->latest()->get();
            return view('admin.subcategories.create', compact('subCategory', 'categories', 'subCategories'));
        } catch (\Exception $e) {
            Log::error('Error fetching subcategory for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the subcategory. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $subCategory = SubCategory::findOrFail($id);

            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $imagePath = $subCategory->image;

            if ($request->hasFile('image')) {
                if ($subCategory->image && $subCategory->image !== 'uploads/no_images/no-image.png' && file_exists(public_path($subCategory->image))) {
                    unlink(public_path($subCategory->image));
                }

                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/subcategory'), $imageName);
                $imagePath = 'uploads/subcategory/' . $imageName;
            }

            $subCategory->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
            ]);

            return redirect()->route('subcategories.create')->with('success', 'Subcategory updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating subcategory: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the subcategory. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $subCategory = SubCategory::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $subCategory->status = $request->status;
            $subCategory->save();

            return back()->with('success', 'Subcategory status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating subcategory status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $subCategory = SubCategory::findOrFail($id);

            if ($subCategory->image && basename($subCategory->image) !== 'no-image.png') {
                $imagePath = public_path($subCategory->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $subCategory->delete();

            return redirect()->route('subcategories.create')->with('success', 'Subcategory deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting subcategory with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('subcategories.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
