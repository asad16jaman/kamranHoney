<?php

namespace App\Http\Controllers\Admin;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        try {
            $blogs = Blog::latest()->get();
            return view('admin.blogs.index', compact('blogs'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the blog index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function view($slug)
    {
        try {
            $blog = Blog::where('slug', $slug)->firstOrFail();
            return view('frontend.pages.blog-details', compact('blog'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the blog page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Blog $blog = null)
    {
        try {
            $allBlogs = Blog::latest()->get();
            return view('admin.blogs.create', compact('allBlogs', 'blog'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the blog create page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3048',
        ]);

        try {
            $slug = Str::slug($request->input('title'), '-');

            $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                ($request->file('image')
                    ? $request->file('image')->getClientOriginalExtension()
                    : '');

            $imagePath = 'uploads/blogs/' . $imageName;

            if ($request->hasFile('image')) {
                $request->file('image')->move(public_path('uploads/blogs'), $imageName);
            } else {
                $imagePath = 'uploads/no_images/no-image.png';
                $imageName = 'no-image.png';
            }

            Blog::create([
                'title' => $request->input('title'),
                'name' => $request->input('name'),
                'slug' => $slug,
                'description' => strip_tags($request->input('description')),
                'image' => $imageName,
                'ip_address' => $request->ip(),
            ]);

            DB::commit();

            return back()->with('success', 'Blog created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while creating the blog: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the blog. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $blog = Blog::findOrFail($id);
            $allBlogs = Blog::latest()->get();
            return view('admin.blogs.create', compact('blog', 'allBlogs'));
        } catch (\Exception $e) {
            Log::error('Error occurred while retrieving the blog for editing: ' . $e->getMessage());
            return redirect()->route('blogs.create')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3048',
        ]);

        try {
            $blog = Blog::findOrFail($id);

            $imageName = $blog->image;

            if ($request->hasFile('image')) {
                $newImageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                    $request->file('image')->getClientOriginalExtension();

                $newImagePath = 'uploads/blogs/' . $newImageName;

                $request->file('image')->move(public_path('uploads/blogs'), $newImageName);

                if ($blog->image && $blog->image !== 'no-image.png') {
                    $oldImagePath = public_path('uploads/blogs/' . $blog->image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $imageName = $newImageName;
            }

            $blog->update([
                'title' => $request->input('title'),
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('title'), '-'),
                'description' => strip_tags($request->input('description')),
                'image' => $imageName,
            ]);

            DB::commit();

            return redirect()->route('blogs.create')->with('success', 'Blog updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while updating the blog: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the blog. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $blog->status = $request->status;
            $blog->save();

            return back()->with('success', 'Blog status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating blog status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $blog = Blog::findOrFail($id);

            if ($blog->image && $blog->image !== 'no-image.png') {
                $imagePath = public_path('uploads/blogs/' . $blog->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $blog->delete();

            return redirect()->back()->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting blog with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
