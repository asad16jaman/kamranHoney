<?php

namespace App\Http\Controllers\admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function toggle(Request $request)
    {
        $productId = $request->input('product_id');
        $favorites = session()->get('favorites', []);

        if (in_array($productId, $favorites)) {
            // Remove from favorites
            $favorites = array_diff($favorites, [$productId]);
            session()->put('favorites', $favorites);
            return response()->json([
                'status' => 'removed',
                'fav_count' => count($favorites),
            ]);
        } else {
            // Add to favorites
            $favorites[] = $productId;
            session()->put('favorites', $favorites);
            return response()->json([
                'status' => 'added',
                'fav_count' => count($favorites),
            ]);
        }
    }

    public function show(Request $request)
    {
        $favoriteIds = session('favorites', []);

        $products = Product::where('status', 'a')
            ->whereIn('id', $favoriteIds)
            ->with(['variants.color', 'variants.size'])
            ->latest()
            ->get();

        $pageTitle = 'My Favorite Products';
        $requestkeyword = null;
        $categories = Category::get();

        return view('frontend.pages.my-fav', compact('products', 'pageTitle', 'requestkeyword', 'categories'));
    }
}
