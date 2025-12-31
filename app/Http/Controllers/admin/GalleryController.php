<?php

namespace App\Http\Controllers\admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    public function photoGallery()
    {
        try {
            $galleryItems = Gallery::where('status', 'a')->latest()->get();
            return view('frontend.pages.photo_gallery', compact('galleryItems'));
        } catch (\Exception $e) {
            Log::error('Error fetching gallery images: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while fetching the gallery images. Please try again later.');
        }
    }

    public function videoGallery()
    {
        try {
            $videoGalleries = Gallery::where('status', 'a')->latest()->get();
            return view('frontend.pages.video_gallery', compact('videoGalleries'));
        } catch (\Exception $e) {
            Log::error('Error fetching gallery images: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while fetching the video galleries. Please try again later.');
        }
    }

    public function index()
    {
        try {
            $galleries = Gallery::latest()->get();
            return view('admin.gallery.index', compact('galleries'));
        } catch (\Exception $e) {
            Log::error('Error fetching gallery: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while fetching the gallery. Please try again later.');
        }
    }

    public function create()
    {
        try {
            $galleries = Gallery::latest()->get();
            return view('admin.gallery.create', compact('galleries'));
        } catch (\Exception $e) {
            Log::error('Error loading create gallery page: ' . $e->getMessage());
            return back()->with('error', 'Failed to load create gallery form.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:image,video',
            'title_1' => 'nullable|string|max:255',
            'title_2' => 'nullable|string|max:255',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            'description' => 'nullable|string|max:1000',
            'video_url' => 'nullable|url|max:255',
        ]);

        try {
            $imageName = null;

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/gallery'), $imageName);
            }

            Gallery::create([
                'type' => $request->type,
                'title_1' => $request->title_1,
                'title_2' => $request->title_2,
                'image' => $imageName,
                'description' => strip_tags($request->description),
                'video_url' => $request->video_url,
                'ip_address' => $request->ip(),
                'status' => 'a',
            ]);

            return redirect()->route('gallery.create')->with('success', 'Gallery item created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating gallery item: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the gallery item. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);
            return view('admin.gallery.edit', compact('gallery'));
        } catch (\Exception $e) {
            Log::error('Error loading edit gallery form: ' . $e->getMessage());
            return back()->with('error', 'gallery not found.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:image,video',
            'title_1' => 'nullable|string|max:255',
            'title_2' => 'nullable|string|max:255',
            // 'image' => 'nullable|image|mimes:jpeg,png,jpg|max:4048',
            'description' => 'nullable|string|max:1000',
            'video_url' => 'nullable|url|max:255',
        ]);

        try {
            $gallery = Gallery::findOrFail($id);

            if ($request->hasFile('image')) {
                if ($gallery->image && file_exists(public_path('uploads/gallery/' . $gallery->image))) {
                    unlink(public_path('uploads/gallery/' . $gallery->image));
                }

                $image = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/gallery'), $imageName);
            } else {
                $imageName = $gallery->image;
            }

            $gallery->update([
                'type' => $request->type,
                'title_1' => $request->title_1,
                'title_2' => $request->title_2,
                'image' => $imageName,
                'description' => strip_tags($request->description),
                'video_url' => $request->video_url,
            ]);

            return redirect()->route('gallery.create')->with('success', 'Gallery item updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating gallery item: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the gallery item. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $gallery->status = $request->status;
            $gallery->save();

            return back()->with('success', 'Gallery status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating gallery status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $gallery = Gallery::findOrFail($id);

            if ($gallery->image && file_exists(public_path('uploads/gallery/' . $gallery->image))) {
                unlink(public_path('uploads/gallery/' . $gallery->image));
            }

            $gallery->delete();

            return redirect()->route('gallery.create')->with('success', 'Gallery item deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting gallery item: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while deleting the gallery item. Please try again later.');
        }
    }
}
