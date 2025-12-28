<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class ProductVariantController extends Controller
{

    public function index()
    {
        try {
            $variants = ProductVariant::with('product', 'size', 'color')->latest()->get();
            return view('admin.products.variants_index', compact('variants'));
        } catch (\Exception $e) {
            Log::error('Error loading products: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'Unable to load products.');
        }
    }

    public function store(Request $request, Product $product)
    {
        $request->validate([
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'stock' => 'required|integer|min:1',
            'price' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
        ]);

        try {
            $variant = $product->variants()
                ->where('size_id', $request->size_id)
                ->where('color_id', $request->color_id)
                ->first();

            if ($variant) {
                $variant->stock += $request->stock;
                if ($request->filled('price')) {
                    $variant->price = $request->price;
                }
                if ($request->filled('discount_price')) {
                    $variant->discount_price = $request->discount_price;
                }
                $variant->save();
            } else {
                $product->variants()->create([
                    'size_id' => $request->size_id,
                    'color_id' => $request->color_id,
                    'stock' => $request->stock,
                    'price' => $request->price,
                    'discount_price' => $request->discount_price,
                ]);
            }

            return back()->with('success', 'Variant saved successfully!');
        } catch (\Exception $e) {
            Log::error('Error saving variant: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }

    public function update(Request $request, ProductVariant $variant)
    {
        $request->validate([
            'size_id' => 'nullable|exists:sizes,id',
            'color_id' => 'nullable|exists:colors,id',
            'stock' => 'required|integer|min:0',
            'price' => 'nullable|numeric',
            'discount_price' => 'nullable|numeric',
        ]);

        try {
            $variant->size_id = $request->size_id;
            $variant->color_id = $request->color_id;
            $variant->stock = $request->stock;
            $variant->price = $request->price;
            $variant->discount_price = $request->discount_price;
            $variant->save();

            return back()->with('success', 'Variant updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating variant: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred. Please try again.');
        }
    }
}
