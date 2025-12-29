<?php

namespace App\Http\Controllers\admin;

use App\Models\Size;
use App\Models\Unit;
use App\Models\Color;
use App\Models\Client;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $products = Product::with('category', 'subCategory', 'client')->latest()->get();
            return view('admin.products.index', compact('products'));
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
            $units = Unit::all();

            $count = Product::count() + 1;
            $nextProductCode = 'P' . str_pad($count, 4, '0', STR_PAD_LEFT);

            return view('admin.products.create', compact('categories', 'subCategories', 'products', 'clients', 'nextProductCode', 'units'));
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
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',

            'inventory' => 'required|array|min:1',
            'inventory.*.unit_id' => 'required|exists:units,id',
            'inventory.*.price' => 'required|numeric|min:0',
            'inventory.*.discount_price' => 'nullable|numeric|min:0',
            'inventory.*.discount_percent' => 'nullable|numeric|min:0',
            'inventory.*.initial_qty' => 'required|numeric|min:0',
            'inventory.*.purchase_qty' => 'nullable|numeric|min:0',
            'inventory.*.sale_qty' => 'nullable|numeric|min:0',

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

            $count = Product::count() + 1;
            $productCode = 'P' . str_pad($count, 4, '0', STR_PAD_LEFT);

            DB::transaction(function () use ($request, $thumbnailPath, $galleryPaths, $productCode) {

                $product = Product::create([
                    'category_id' => $request->category_id,
                    'sub_category_id' => $request->sub_category_id,
                    'client_id' => $request->client_id,
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'short_description' => strip_tags($request->short_description),
                    'description' => strip_tags($request->description),
                    'product_code' => $productCode,
                    'thumbnail_image' => $thumbnailPath,
                    'gallery_images' => json_encode($galleryPaths),
                    'ip_address' => $request->ip(),
                ]);

                foreach ($request->inventory as $item) {
                    $product->inventory()->create([
                        'unit_id' => $item['unit_id'],
                        'price' => $item['price'],
                        'discount_price' => $item['discount_price'] ?? null,
                        'discount_percent' => $item['discount_percent'] ?? null,
                        'initial_qty' => $item['initial_qty'],
                        'purchase_qty' => 0,
                        'sale_qty' => 0,
                        'ip_address' => $request->ip(),
                    ]);
                }
            });

            return redirect()->route('products.index')->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating product: ' . $e->getMessage());
            return back()->with('error', 'Unexpected error occurred.');
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::with('inventory')->findOrFail($id);
            $categories = Category::all();
            $subCategories = SubCategory::all();
            $clients = Client::all();
            $units = Unit::all();

            return view('admin.products.edit', compact('product', 'categories', 'subCategories', 'clients', 'units'));
        } catch (\Exception $e) {
            Log::error('Error fetching product for edit: ' . $e->getMessage());
            return back()->with('error', 'Could not load product.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'client_id' => 'required|exists:clients,id',
            'name' => 'required|string|max:255',
            'thumbnail_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',

            'inventory' => 'required|array|min:1',
            'inventory.*.unit_id' => 'required|exists:units,id',
            'inventory.*.price' => 'required|numeric|min:0',
            'inventory.*.discount_price' => 'nullable|numeric|min:0',
            'inventory.*.discount_percent' => 'nullable|numeric|min:0',
            'inventory.*.initial_qty' => 'required|numeric|min:0',
        ]);

        try {
            $product = Product::findOrFail($id);

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

            if ($request->has('remove_gallery_images')) {
                foreach ($request->remove_gallery_images as $index) {
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

            DB::transaction(function () use ($request, $product, $thumbnailPath, $galleryPaths) {

                $product->update([
                    'category_id' => $request->category_id,
                    'sub_category_id' => $request->sub_category_id,
                    'client_id' => $request->client_id,
                    'name' => $request->name,
                    'slug' => Str::slug($request->name),
                    'short_description' => strip_tags($request->short_description),
                    'description' => strip_tags($request->description),
                    'thumbnail_image' => $thumbnailPath,
                    'gallery_images' => json_encode(array_values($galleryPaths)),
                    'ip_address' => $request->ip(),
                ]);

                $product->inventory()->delete();

                foreach ($request->inventory as $item) {
                    $product->inventory()->create([
                        'unit_id' => $item['unit_id'],
                        'price' => $item['price'],
                        'discount_price' => $item['discount_price'] ?? null,
                        'discount_percent' => $item['discount_percent'] ?? null,
                        'initial_qty' => $item['initial_qty'],
                        'purchase_qty' => 0,
                        'sale_qty' => 0,
                        'ip_address' => $request->ip(),
                    ]);
                }
            });

            return redirect()->route('products.index')->with('success', 'Product updated successfully.');
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

            return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting product: ' . $e->getMessage());
            return back()->with('error', 'Could not delete the product.');
        }
    }
}
