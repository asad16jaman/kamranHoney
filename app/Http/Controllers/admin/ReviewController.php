<?php

namespace App\Http\Controllers\Admin;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index()
    {
        try {
            $reviews = Review::latest()->get();
            return view('admin.reviews.index', compact('reviews'));
        } catch (\Exception $e) {
            Log::error('Error loading reviews index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function create(?Review $review = null)
    {
        try {
            $reviews = Review::latest()->get();
            return view('admin.reviews.create', compact('reviews', 'review'));
        } catch (\Exception $e) {
            Log::error('Error displaying create review page: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while loading the review creation page.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'nullable|string|max:255',
            'review' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            $imagePath = 'uploads/no_images/no-image.png';

            if ($request->hasFile('image')) {
                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/review'), $imageName);
                $imagePath = 'uploads/review/' . $imageName;
            }

            Review::create([
                'name' => $request->name,
                'title' => $request->title,
                'review' => strip_tags($request->review),
                'image' => $imagePath,
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('review.create')->with('success', 'Review created successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while creating review: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating the review.');
        }
    }

    public function edit($id)
    {
        try {
            $review = Review::findOrFail($id);
            $reviews = Review::latest()->get();
            return view('admin.reviews.create', compact('review', 'reviews'));
        } catch (\Exception $e) {
            Log::error('Error fetching review for editing: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the review.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $review = Review::findOrFail($id);

            $request->validate([
                'name' => 'required|string|max:255',
                'title' => 'nullable|string|max:255',
                'review' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $imagePath = $review->image;

            if ($request->hasFile('image')) {
                if ($review->image && $review->image !== 'uploads/no_images/no-image.png' && file_exists(public_path($review->image))) {
                    unlink(public_path($review->image));
                }

                $imageFile = $request->file('image');
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' . $imageFile->getClientOriginalExtension();
                $imageFile->move(public_path('uploads/review'), $imageName);
                $imagePath = 'uploads/review/' . $imageName;
            }

            $review->update([
                'name' => $request->name,
                'title' => $request->title,
                'review' => strip_tags($request->review),
                'image' => $imagePath,
            ]);

            return redirect()->route('review.create')->with('success', 'Review updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating review: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the review.');
        }
    }

    public function view()
    {
        try {
            $reviews = Review::where('status', 'a')->latest()->get();
            return view('frontend.pages.reviews', compact('reviews'));
        } catch (\Exception $e) {
            Log::error('Error fetching review content: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'An error occurred while fetching the review content. Please try again later.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $review = Review::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $review->status = $request->status;
            $review->save();

            return back()->with('success', 'Review status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating review status: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the status.');
        }
    }

    public function destroy($id)
    {
        try {
            $review = Review::findOrFail($id);

            if ($review->image && basename($review->image) !== 'no-image.png') {
                $imagePath = public_path($review->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $review->delete();

            return redirect()->route('review.create')->with('success', 'Review deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting review with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('review.create')->with('error', 'An error occurred while deleting the review.');
        }
    }
}
