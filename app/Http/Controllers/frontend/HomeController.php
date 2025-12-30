<?php

namespace App\Http\Controllers\frontend;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Banner;
use App\Models\Client;
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
    // public function home()
    // {
    //     try {
    //         $sliders = Slider::where('status', 'a')->latest()->get();
    //         $categories = Category::withCount('products')->where('status', 'a')->latest()->get();
    //         $features = Feature::where('status', 'a')->get();
    //         $banners = Banner::where('status', 'a')->get();
    //         $featuredProducts = Product::with('variants')->where('is_featured', 'Yes')->where('status', 'a')->latest()->get();
    //         $newArrival = Product::with('variants')->where('is_new', 'Yes')->where('status', 'a')->latest()->get();
    //         $brands = Client::where('status', 'a')->get();
    //         $faqs = Faq::where('status', 'a')->latest()->get();
    //         return view('frontend.pages.home', compact('categories', 'sliders', 'features', 'banners', 'featuredProducts', 'newArrival', 'faqs', 'brands'));
    //     } catch (\Exception $e) {
    //         Log::error('Error fetching sliders: ' . $e->getMessage());
    //         return redirect()->route('home')->with('error', 'There was an error loading the sliders. Please try again later.');
    //     }
    // }

    public function home()
    {
        try {
            $categories = Category::where('status', 'a')->latest()->get();
            $products = Product::with(['inventory.unit', 'category', 'client'])->where('status', 'a')->latest()->take(8)->get();
            $blogs = Blog::where('status', 'a')->latest()->get();
            return view('frontend.pages.home', compact('categories', 'products', 'blogs'));
        } catch (\Exception $e) {
            Log::error('Error fetching sliders: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'There was an error loading the sliders. Please try again later.');
        }
    }
}
