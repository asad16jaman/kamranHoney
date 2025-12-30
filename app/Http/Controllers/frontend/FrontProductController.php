<?php

namespace App\Http\Controllers\frontend;

use App\Models\Client;
use App\Models\Review;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class FrontProductController extends Controller
{


    public function index()
    {
        try {
            $products = Product::with(['inventory.unit', 'category', 'client'])->where('status', 'a')->latest()->paginate(12);
            return view('frontend.pages.all_products', compact('products'));
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'There was an error loading the products. Please try again later.');
        }
    }

    public function show($slug)
    {
        try {
            $product = Product::with(['inventory.unit', 'category', 'client'])->where('status', 'a')->where('slug', $slug)->firstOrFail();

            $relatedProducts = Product::with(['inventory.unit', 'category', 'client'])
                ->where('status', 'a')
                ->where('category_id', $product->category_id)
                ->where('id', '!=', $product->id)
                ->latest()
                ->take(4)
                ->get();

            return view('frontend.pages.product_detail', compact('product', 'relatedProducts'));
        } catch (\Exception $e) {
            Log::error('Error fetching product details: ' . $e->getMessage());
            return redirect()->route('all.products')->with('error', 'Product not found.');
        }
    }
}
