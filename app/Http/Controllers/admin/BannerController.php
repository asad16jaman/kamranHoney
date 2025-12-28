<?php

namespace App\Http\Controllers\admin;

use App\Models\Banner;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        try {
            $banners = Banner::latest()->get();
            return view('admin.banners.index', compact('banners'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the banners index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function showProducts($id)
    {
        try {
            $banner = Banner::with(['products.variants'])->findOrFail($id);
            $categories = Category::where('status', 'a')->get();

            $now = now();
            $offerActive = true;

            if ($banner->end_date && $now->greaterThan(\Carbon\Carbon::parse($banner->end_date))) {
                $offerActive = false;
            }

            $products = $banner->products->map(function ($product) use ($banner, $offerActive) {
                $product->original_price = $product->price;

                if ($offerActive && $banner->discount && $banner->discount > 0) {
                    $product->discount_price = round($product->price - ($product->price * ($banner->discount / 100)));
                } else {
                    $product->discount_price = null;
                }

                return $product;
            });

            return view('frontend.pages.banner_products', compact('products', 'banner', 'categories', 'offerActive'));
        } catch (\Exception $e) {
            Log::error('Error loading banner products: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'Unable to load banner products.');
        }
    }

    public function create(?Banner $banner = null)
    {
        try {
            $banners = Banner::latest()->get();
            $products = Product::select('id', 'name')->latest()->get(); // Fetch for multi-select
            return view('admin.banners.create', compact('banners', 'banner', 'products'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the banner create page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png|max:2048',
            'title_one'    => 'nullable|string|max:255',
            'title_two'    => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'discount'     => 'nullable|numeric|min:0',
            'button_text'  => 'nullable|string|max:100',
            'status'       => 'nullable|in:a,d',
            'product_ids'  => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        try {
            $imageName = 'no-image.png';

            if ($request->hasFile('banner_image')) {
                $imageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                    $request->file('banner_image')->getClientOriginalExtension();

                $request->file('banner_image')->move(public_path('uploads/banners'), $imageName);
            }

            $banner = Banner::create([
                'banner_image' => $imageName,
                'title_one'    => $request->input('title_one'),
                'title_two'    => $request->input('title_two'),
                'description'  => strip_tags($request->input('description')),
                'start_date'   => $request->input('start_date'),
                'end_date'     => $request->input('end_date'),
                'discount'     => $request->input('discount'),
                'button_text'  => $request->input('button_text'),
                'status'       => $request->input('status', 'a'),
                'ip_address'   => $request->ip(),
            ]);

            if ($request->filled('product_ids')) {
                $banner->products()->attach($request->input('product_ids'));
            }

            DB::commit();
            return back()->with('success', 'Banner created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while creating the banner: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while creating the banner.');
        }
    }

    public function edit($id)
    {
        try {
            $banner = Banner::with('products')->findOrFail($id);
            $banners = Banner::latest()->get();
            $products = Product::select('id', 'name')->latest()->get();
            $selectedProductIds = $banner->products->pluck('id')->toArray();

            return view('admin.banners.create', compact('banner', 'banners', 'products', 'selectedProductIds'));
        } catch (\Exception $e) {
            Log::error('Error occurred while retrieving the banner for editing: ' . $e->getMessage());
            return redirect()->route('banners.create')->with('error', 'An unexpected error occurred.');
        }
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        $request->validate([
            'banner_image'  => 'nullable|image|mimes:jpeg,png|max:2048',
            'title_one'     => 'nullable|string|max:255',
            'title_two'     => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date|after_or_equal:start_date',
            'discount'      => 'nullable|numeric|min:0',
            'button_text'   => 'nullable|string|max:100',
            'status'        => 'nullable|in:a,d',
            'product_ids'   => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        try {
            $banner = Banner::findOrFail($id);
            $imageName = $banner->banner_image;

            if ($request->hasFile('banner_image')) {
                $newImageName = now()->format('Ymd') . rand(1000, 9999) . '.' .
                    $request->file('banner_image')->getClientOriginalExtension();

                $request->file('banner_image')->move(public_path('uploads/banners'), $newImageName);

                if ($banner->banner_image && $banner->banner_image !== 'no-image.png') {
                    $oldImagePath = public_path('uploads/banners/' . $banner->banner_image);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $imageName = $newImageName;
            }

            $banner->update([
                'banner_image' => $imageName,
                'title_one'    => $request->input('title_one'),
                'title_two'    => $request->input('title_two'),
                'description'  => strip_tags($request->input('description')),
                'start_date'   => $request->input('start_date'),
                'end_date'     => $request->input('end_date'),
                'discount'     => $request->input('discount'),
                'button_text'  => $request->input('button_text'),
                'status'       => $request->input('status', 'a'),
            ]);

            // Sync selected products
            $banner->products()->sync($request->input('product_ids', []));

            DB::commit();

            return redirect()->route('banners.create')->with('success', 'Banner updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while updating the banner: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the banner.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $banner = Banner::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $banner->status = $request->status;
            $banner->save();

            return back()->with('success', 'Banner status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating banner status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function destroy($id)
    {
        try {
            $banner = Banner::findOrFail($id);

            if ($banner->banner_image && $banner->banner_image !== 'no-image.png') {
                $imagePath = public_path('uploads/banners/' . $banner->banner_image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $banner->delete();

            return redirect()->back()->with('success', 'Banner deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting banner with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->back()->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}