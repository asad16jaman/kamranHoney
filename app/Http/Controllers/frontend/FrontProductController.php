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
            return view('frontend.pages.all_products'); 
        } catch (\Exception $e) {
            Log::error('Error fetching products: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'There was an error loading the products. Please try again later.');
        }
    }
}
