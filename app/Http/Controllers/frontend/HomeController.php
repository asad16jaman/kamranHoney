<?php

namespace App\Http\Controllers\frontend;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Banner;
use App\Models\Client;
use App\Models\Review;
use App\Models\Slider;
use App\Models\AboutUs;
use App\Models\Feature;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function home()
    {
        try {
            $categories = Category::where('status', 'a')->latest()->get();
            $products = Product::with(['inventory.unit', 'category', 'client'])->where('status', 'a')->latest()->take(8)->get();
            $blogs = Blog::where('status', 'a')->latest()->get();
            $reviews = Review::where('status', 'a')->latest()->get();
            $galleryImages = Gallery::where('type', 'image')->where('status', 'a')->take(10)->get();
            $videos = Gallery::where('type', 'video')->where('status', 'a')->take(5)->get();
            return view('frontend.pages.home', compact('categories', 'products', 'blogs', 'reviews', 'galleryImages', 'videos'));
        } catch (\Exception $e) {
            Log::error('Error fetching sliders: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'There was an error loading the sliders. Please try again later.');
        }
    }
}
