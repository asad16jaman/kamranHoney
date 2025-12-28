<?php

namespace App\Http\Controllers\frontend;

use Carbon\Carbon;
use App\Models\Coupon;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CartController extends Controller
{

    protected function getCartKey()
    {
        $userId = auth('customer')->id();
        return 'cart_' . $userId;
    }

    // public function cartModal($slug)
    // {
    //     $product = Product::with('variants.size', 'variants.color')->where('slug', $slug)->firstOrFail();

    //     $thumbnail = asset($product->thumbnail_image);
    //     $variantMap = [];
    //     $hasSize = false;

    //     foreach ($product->variants as $variant) {
    //         $color = optional($variant->color)->name;
    //         $size = optional($variant->size)->name;
    //         $stock = $variant->stock;

    //         if ($color && $size) {
    //             $variantMap[$color][$size] = $stock;
    //             $hasSize = true;
    //         } elseif ($color && !$size) {
    //             $variantMap[$color] = $stock;
    //         }
    //     }

    //     return response()->json([
    //         'image' => $thumbnail,
    //         'variants' => $variantMap,
    //         'colors' => array_keys($variantMap),
    //         'hasSize' => $hasSize
    //     ]);
    // }

    public function cartModal($slug)
    {
        $product = Product::with('variants.size', 'variants.color')->where('slug', $slug)->firstOrFail();

        $thumbnail = asset($product->thumbnail_image);
        $variantMap = [];
        $hasSize = false;
        $hasColor = false;

        foreach ($product->variants as $variant) {
            $color = optional($variant->color)->name;
            $size = optional($variant->size)->name;
            $stock = $variant->stock;

            if ($color && $size) {
                $variantMap[$color][$size] = $stock;
                $hasSize = true;
                $hasColor = true;
            } elseif ($color && !$size) {
                $variantMap[$color] = $stock;
                $hasColor = true;
            } elseif (!$color && $size) {
                $variantMap[$size] = $stock;
                $hasSize = true;
            }
        }

        return response()->json([
            'image' => $thumbnail,
            'variants' => $variantMap,
            'colors' => $hasColor ? array_keys($variantMap) : [],
            'hasSize' => $hasSize
        ]);
    }

    public function addToCart(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->with('variants.size', 'variants.color')
            ->firstOrFail();

        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $quantity = max((int) $request->input('quantity', 1), 1);

        $size = $request->input('size');
        $color = $request->input('color');

        $availableSizes = $product->variants
            ->pluck('size.name')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $availableColors = $product->variants
            ->pluck('color.name')
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        $matchedVariant = $product->variants->first(function ($variant) use ($size, $color) {
            $variantSizeName = optional($variant->size)->name;
            $variantColorName = optional($variant->color)->name;

            if ($size && $color) {
                return $variantSizeName === $size && $variantColorName === $color;
            } elseif ($size) {
                return $variantSizeName === $size;
            } elseif ($color) {
                return $variantColorName === $color;
            } else {
                return true;
            }
        });


        $variantId = $matchedVariant ? $matchedVariant->id : null;


        $cartKey = $this->getCartKey();
        $cart = session()->get($cartKey, []);

        $uniqueId = $product->id . '-' . ($size ?? 'nosize') . '-' . ($color ?? 'nocolor');

        if (isset($cart[$uniqueId])) {
            $cart[$uniqueId]['quantity'] += $quantity;
        } else {
            $cart[$uniqueId] = [
                "product_id" => $product->id,
                "variant_id" => $variantId,
                "name" => $product->name,
                "slug" => $product->slug,
                "price" => $product->price,
                "discount_price" => $product->discount_price,
                "image" => $product->thumbnail_image,
                "quantity" => $quantity,
                "size" => $size,
                "color" => $color,
                "available_sizes" => $availableSizes,
                "available_colors" => $availableColors,
            ];
        }

        session()->put($cartKey, $cart);

        if ($request->ajax()) {
            $cartCount = collect($cart)->sum('quantity');
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart!',
                'cart_count' => $cartCount
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function showCart()
    {
        $cartKey = $this->getCartKey();
        $cart = session()->get($cartKey, []);

        if (empty($cart)) {
            session()->forget('coupon');
        }

        $showColor = collect($cart)->contains(function ($item) {
            return !empty($item['available_colors']);
        });

        $showSize = collect($cart)->contains(function ($item) {
            return !empty($item['available_sizes']);
        });

        return view('frontend.pages.cart', compact('cart', 'showColor', 'showSize'));
    }


    public function applyCoupon(Request $request)
    {
        $request->validate([
            'coupon_code' => 'required|string'
        ]);

        $code = $request->coupon_code;
        $coupon = Coupon::where('code', $code)->where('status', 'a')->first();

        if (!$coupon) {
            return response()->json(['message' => 'Invalid or inactive coupon.'], 422);
        }

        $today = Carbon::today();

        if (
            ($coupon->start_date && $today->lt(Carbon::parse($coupon->start_date))) ||
            ($coupon->end_date && $today->gt(Carbon::parse($coupon->end_date)))
        ) {
            return response()->json(['message' => 'Coupon is not valid at this time.'], 422);
        }

        if ($coupon->usage_limit !== null && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['message' => 'This coupon has reached its total usage limit.'], 422);
        }

        $customerId = auth('customer')->id();

        $userUsedCount = DB::table('coupon_user')
            ->where('coupon_id', $coupon->id)
            ->where('customer_id', $customerId)
            ->value('used_count') ?? 0;

        if ($coupon->usage_limit_per_user !== null && $userUsedCount >= $coupon->usage_limit_per_user) {
            return response()->json(['message' => 'Limit Reached.'], 422);
        }

        session()->put('coupon', [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'id' => $coupon->id
        ]);

        return response()->json(['message' => 'Coupon applied successfully!']);
    }


    public function updateAjax(Request $request)
    {
        $cartKey = $this->getCartKey();
        $cart = session()->get($cartKey, []);

        $id = $request->id;

        // Remove item logic
        if ($request->has('remove') && $request->remove == true) {
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put($cartKey, $cart);

                if (empty($cart)) {
                    session()->forget('coupon');
                }

                $subtotal = array_reduce($cart, function ($sum, $item) {
                    $price = $item['discount_price'] ?? $item['price'];
                    return $sum + ($price * $item['quantity']);
                }, 0);

                $cartCount = collect($cart)->sum('quantity');

                $isCouponRemoved = empty($cart);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Product removed from cart.',
                    'subtotal' => $subtotal,
                    'total' => $subtotal,
                    'cart_count' => $cartCount,
                    'coupon_removed' => $isCouponRemoved,
                ]);
            }

            return response()->json(['error' => 'Item not found in cart.'], 404);
        }

        // Invalid item check
        if (!isset($cart[$id])) {
            return response()->json(['error' => 'Invalid item.'], 400);
        }

        $item = $cart[$id];

        // Update quantity
        if ($request->has('quantity')) {
            $item['quantity'] = max((int) $request->quantity, 1);
        }

        // Safe fallback for size/color
        $availableSizes = $item['available_sizes'] ?? [];
        $availableColors = $item['available_colors'] ?? [];

        $hasSizes = is_array($availableSizes) && count($availableSizes) > 0;
        $hasColors = is_array($availableColors) && count($availableColors) > 0;

        $newSize = $hasSizes ? ($request->input('size') ?? $item['size'] ?? null) : null;
        $newColor = $hasColors ? ($request->input('color') ?? $item['color'] ?? null) : null;

        // Get correct variant_id based on new size/color
        $matched = \App\Models\Product::find($item['product_id'])
            ->variants
            ->first(function ($v) use ($newSize, $newColor) {
                $variantSizeName = optional($v->size)->name;
                $variantColorName = optional($v->color)->name;

                if ($newSize && $newColor) {
                    return $variantSizeName === $newSize && $variantColorName === $newColor;
                } elseif ($newSize) {
                    return $variantSizeName === $newSize;
                } elseif ($newColor) {
                    return $variantColorName === $newColor;
                } else {
                    return true;
                }
            });

        $item['variant_id'] = $matched ? $matched->id : null;


        // Remove old item
        unset($cart[$id]);

        // Generate new unique ID
        $newId = $item['product_id'] . '-' . ($newSize ?? 'nosize') . '-' . ($newColor ?? 'nocolor');

        if (isset($cart[$newId])) {
            $cart[$newId]['quantity'] += $item['quantity'];
        } else {
            $item['size'] = $newSize;
            $item['color'] = $newColor;
            $cart[$newId] = $item;
        }

        // Save updated cart
        session()->put($cartKey, $cart);

        $unitPrice = $item['discount_price'] ?? $item['price'];
        $itemTotal = $unitPrice * $item['quantity'];

        $subtotal = array_reduce($cart, function ($sum, $item) {
            $price = $item['discount_price'] ?? $item['price'];
            return $sum + ($price * $item['quantity']);
        }, 0);

        return response()->json([
            'item_total' => $itemTotal,
            'subtotal' => $subtotal,
            'total' => $subtotal,
            'new_id' => $newId,
        ]);
    }
}
