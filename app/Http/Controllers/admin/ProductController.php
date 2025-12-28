<?php

namespace App\Http\Controllers\admin;

use App\Models\Size;
use App\Models\Color;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with('category', 'subCategory', 'client')->latest()->get();

            $sizes = Size::all();
            $colors = Color::all();
            return view('admin.products.index', compact('products', 'sizes', 'colors'));
        } catch (\Exception $e) {
            Log::error('Error loading products: ' . $e->getMessage());
            return redirect()->route('admin.dashboard')->with('error', 'Unable to load products.');
        }
    }

    public function create()
    {
        try {
            $categories = Category::all();
            $subCategories = SubCategory::all();
            $clients = Client::all();
            $products = Product::with('category', 'subCategory')->latest()->get();
            $sizes = Size::all();
            $colors = Color::all();

            return view('admin.products.create', compact('categories', 'subCategories', 'products', 'sizes', 'colors', 'clients'));
        } catch (\Exception $e) {
            Log::error('Error displaying product create page: ' . $e->getMessage());
            return back()->with('error', 'Error loading create product page.');
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'product_code' => 'nullable|string|max:255',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'sizes' => 'nullable|array',
            // 'sizes.*' => 'string',
            // 'colors' => 'nullable|array',
            // 'colors.*' => 'string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'is_featured' => 'nullable|in:Yes,No',
            'is_top_selling' => 'nullable|in:Yes,No',
            'is_popular' => 'nullable|in:Yes,No',
            'is_special' => 'nullable|in:Yes,No',
            'is_best' => 'nullable|in:Yes,No',
            'is_new' => 'nullable|in:Yes,No',
        ]);

        try {
            $thumbnailPath = null;
            if ($request->hasFile('thumbnail_image')) {
                $thumb = $request->file('thumbnail_image');
                $thumbName = now()->format('YmdHis') . '_thumb.' . $thumb->getClientOriginalExtension();
                $thumb->move(public_path('uploads/product/thumbnails'), $thumbName);
                $thumbnailPath = 'uploads/product/thumbnails/' . $thumbName;
            }

            $galleryPaths = [];
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $imgName = now()->format('YmdHis') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/product/gallery'), $imgName);
                    $galleryPaths[] = 'uploads/product/gallery/' . $imgName;
                }
            }

            Product::create([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'client_id' => $request->client_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'short_description' => strip_tags($request->short_description),
                'description' => strip_tags($request->description),
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'product_code' => $request->product_code,
                'thumbnail_image' => $thumbnailPath,
                'gallery_images' => json_encode($galleryPaths),
                // 'sizes' => array_map('trim', explode(',', $request->sizes[0])),
                // 'colors' => array_map('trim', explode(',', $request->colors[0] ?? '')),
                'is_featured' => $request->is_featured ?? 'No',
                'is_top_selling' => $request->is_top_selling ?? 'No',
                'is_popular' => $request->is_popular ?? 'No',
                'is_special' => $request->is_special ?? 'No',
                'is_best' => $request->is_best ?? 'No',
                'is_new' => $request->is_new ?? 'No',
                'ip_address' => $request->ip(),
            ]);

            return redirect()->route('products.create')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->with('error', 'Unexpected error occurred.');
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            $categories = Category::all();
            $clients = Client::all();

            $subCategories = $product->category
                ? $product->category->subCategories()->get()
                : collect();

            return view('admin.products.edit', compact('product', 'categories', 'clients', 'subCategories'));
        } catch (\Exception $e) {
            Log::error('Error fetching product for edit: ' . $e->getMessage());
            return back()->with('error', 'Could not load product.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'category_id' => 'required|exists:categories,id',
                'sub_category_id' => 'nullable|exists:sub_categories,id',
                'client_id' => 'required|exists:clients,id',
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'discount_price' => 'nullable|numeric|min:0',
                'product_code' => 'nullable|string|max:255',
                'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                // 'sizes' => 'nullable|array',
                // 'sizes.*' => 'string',
                // 'colors' => 'nullable|array',
                // 'colors.*' => 'string',
                'short_description' => 'nullable|string',
                'description' => 'nullable|string',
                'is_featured' => 'nullable|in:Yes,No',
                'is_top_selling' => 'nullable|in:Yes,No',
                'is_popular' => 'nullable|in:Yes,No',
                'is_special' => 'nullable|in:Yes,No',
                'is_best' => 'nullable|in:Yes,No',
                'is_new' => 'nullable|in:Yes,No',
            ]);

            $thumbnailPath = $product->thumbnail_image;

            if ($request->hasFile('thumbnail_image')) {
                if ($thumbnailPath && file_exists(public_path($thumbnailPath))) {
                    unlink(public_path($thumbnailPath));
                }

                $thumb = $request->file('thumbnail_image');
                $thumbName = now()->format('YmdHis') . '_thumb.' . $thumb->getClientOriginalExtension();
                $thumb->move(public_path('uploads/product/thumbnails'), $thumbName);
                $thumbnailPath = 'uploads/product/thumbnails/' . $thumbName;
            }

            $galleryPaths = json_decode($product->gallery_images, true) ?? [];

            // Check for gallery images to remove
            if ($request->has('remove_gallery_images')) {
                $removeGalleryImages = $request->remove_gallery_images;
                foreach ($removeGalleryImages as $index) {
                    if (isset($galleryPaths[$index]) && file_exists(public_path($galleryPaths[$index]))) {
                        unlink(public_path($galleryPaths[$index]));
                        unset($galleryPaths[$index]);
                    }
                }
            }

            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $image) {
                    $imgName = now()->format('YmdHis') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/product/gallery'), $imgName);
                    $galleryPaths[] = 'uploads/product/gallery/' . $imgName;
                }
            }

            // $sizes = [];

            // if (!empty($request->sizes) && is_array($request->sizes)) {
            //     if (isset($request->sizes[0]) && strpos($request->sizes[0], ',') !== false) {
            //         $sizes = array_map('trim', explode(',', $request->sizes[0]));
            //     } else {
            //         $sizes = $request->sizes;
            //     }
            // }

            // $colors = [];
            // if (!empty($request->colors) && is_array($request->colors)) {
            //     if (isset($request->colors[0]) && strpos($request->colors[0], ',') !== false) {
            //         $colors = array_map('trim', explode(',', $request->colors[0]));
            //     } else {
            //         $colors = $request->colors;
            //     }
            // }

            $product->update([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'client_id' => $request->client_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'short_description' => strip_tags($request->short_description),
                'description' => strip_tags($request->description),
                'price' => $request->price,
                'discount_price' => $request->discount_price,
                'product_code' => $request->product_code,
                'thumbnail_image' => $thumbnailPath,
                'gallery_images' => json_encode(array_values($galleryPaths)),
                // 'sizes' => $sizes,
                // 'colors' => $colors,
                'is_featured' => $request->is_featured ?? 'No',
                'is_top_selling' => $request->is_top_selling ?? 'No',
                'is_popular' => $request->is_popular ?? 'No',
                'is_special' => $request->is_special ?? 'No',
                'is_best' => $request->is_best ?? 'No',
                'is_new' => $request->is_new ?? 'No',
            ]);

            return redirect()->route('products.create')->with('success', 'Product updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating product: ' . $e->getMessage());
            return back()->with('error', 'Unexpected error occurred during update.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $product = Product::findOrFail($id);

            $request->validate([
                'status' => 'required|in:a,d',
            ]);

            $product->status = $request->status;
            $product->save();

            return back()->with('success', 'Product status updated.');
        } catch (\Exception $e) {
            Log::error('Error updating product status: ' . $e->getMessage());
            return back()->with('error', 'Unable to update product status.');
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->thumbnail_image && file_exists(public_path($product->thumbnail_image))) {
                unlink(public_path($product->thumbnail_image));
            }

            if ($product->gallery_images) {
                foreach (json_decode($product->gallery_images) as $img) {
                    if (file_exists(public_path($img))) {
                        unlink(public_path($img));
                    }
                }
            }

            $product->delete();

            return redirect()->route('products.create')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return back()->with('error', 'Could not delete the product.');
        }
    }
}
