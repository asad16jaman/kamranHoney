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
            Log::error('Error fetching Reviews content: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while fetching the Reviews content. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        try {
            $customer = auth('customer')->user();

            if (!$customer) {
                return back()->with('error', 'You must be logged in to leave a review.');
            }

            Review::create([
                'product_id' => $request->product_id,
                'customer_id' => $customer->id,
                'message'    => $request->message,
                'rating'     => $request->rating,
                'ip_address' => $request->ip(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return back()->with('success', 'Review submitted successfully.');
        } catch (\Exception $e) {
            Log::error('Error while storing review: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again.');
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

            return back()->with('success', 'Review status updated.');
        } catch (\Exception $e) {
            Log::error('Error updating review status: ' . $e->getMessage());
            return back()->with('error', 'Unable to update review status.');
        }
    }


    public function destroy($id)
    {
        try {

            $review = Review::findOrFail($id);

            $review->delete();

            return redirect()->route('reviews.index')->with('success', 'Review deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting Review: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while deleting the Review. Please try again later.');
        }
    }
}
