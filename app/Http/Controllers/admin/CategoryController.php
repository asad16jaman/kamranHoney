<?php

namespace App\Http\Controllers\admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $categories = Category::latest()->get();
            return view('admin.categories.index', compact('categories'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the categories index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Category $category = null)
    {
        try {
            $categories = Category::latest()->get();
            return view('admin.categories.create', compact('categories', 'category'));
        } catch (\Exception $e) {
            Log::error('Error displaying create category page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while trying to load the create category page. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $imagePath = 'uploads/no_images/no-image.png';

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/category'), $imageName);
                $imagePath = 'uploads/category/' . $imageName;
            }

            Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('categories.create')->with('success', 'Category created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating category: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the category. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $category = Category::findOrFail($id);
            $categories = Category::latest()->get();
            return view('admin.categories.create', compact('category', 'categories'));
        } catch (\Exception $e) {
            Log::error('Error fetching category for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the category. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $imagePath = $category->image;

            if ($request->hasFile('image')) {

                if ($category->image && $category->image !== 'uploads/no_images/no-image.png' && file_exists(public_path($category->image))) {
                    unlink(public_path($category->image));
                }

                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/category'), $imageName);
                $imagePath = 'uploads/category/' . $imageName;
            }

            $category->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'image' => $imagePath,
            ]);

            return redirect()->route('categories.create')->with('success', 'Category updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating category: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the category. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $category = Category::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $category->status = $request->status;
            $category->save();

            return back()->with('success', 'Category status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating category status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);

            if ($category->image && basename($category->image) !== 'no-image.png') {
                $imagePath = public_path($category->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $category->delete();

            return redirect()->route('categories.create')->with('success', 'Category deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting category with ID ' . $category->id . ': ' . $e->getMessage());
            return redirect()->route('categories.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
