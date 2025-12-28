<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    protected function getCartKey()
    {
        $userId = auth('customer')->id();
        return 'cart_' . $userId;
    }

    public function index()
    {
        $userId = auth('customer')->id();
        $customer = auth('customer')->user();
        $cartKey = 'cart_' . $userId;

        $cart = session()->get($cartKey, []);

        $subtotal = collect($cart)->sum(function ($item) {
            $unitPrice = !empty($item['discount_price'])
                ? $item['discount_price']
                : $item['price'];
            return $unitPrice * $item['quantity'];
        });

        $couponDiscount = 0;
        $coupon = null;

        if (session()->has('coupon')) {
            $coupon = session('coupon');

            if ($coupon['type'] === 'percent') {
                $couponDiscount = ($subtotal * $coupon['value']) / 100;
            } elseif ($coupon['type'] === 'fixed') {
                $couponDiscount = $coupon['value'];
            }

            // Prevent discount from exceeding subtotal
            $couponDiscount = min($couponDiscount, $subtotal);
        }

        $shipping = 0;
        $total = $subtotal - $couponDiscount + $shipping;

        return view('frontend.pages.checkout', compact(
            'cart',
            'subtotal',
            'shipping',
            'total',
            'customer',
            'couponDiscount',
            'coupon'
        ));
    }

    public function store(Request $request)
    {
        $cartKey = $this->getCartKey();
        $cart = session()->get($cartKey, []);

        $request->validate([
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20',
            'delivery_zone' => 'required|in:inside_dhaka,outside_dhaka',
            'payment_method' => 'required|string|in:bkash,nagad,cod',
        ]);

        if (empty($cart)) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty.');
        }

        try {

            $subtotal = collect($cart)->sum(function ($item) {
                $unitPrice = !empty($item['discount_price']) ? $item['discount_price'] : $item['price'];
                return $unitPrice * $item['quantity'];
            });

            // Shipping logic
            $setting = Setting::first();

            $insideCharge = $setting->inside ?? 0;
            $outsideCharge = $setting->outside ?? 0;

            $shipping = $request->delivery_zone === 'inside_dhaka' ? $insideCharge : $outsideCharge;

            $couponDiscount = 0;
            $coupon = null;

            if (session()->has('coupon')) {
                $coupon = \App\Models\Coupon::where('code', session('coupon.code'))->first();

                if ($coupon) {
                    if ($coupon->type === 'percent') {
                        $couponDiscount = ($subtotal * $coupon->value) / 100;
                    } elseif ($coupon->type === 'fixed') {
                        $couponDiscount = $coupon->value;
                    }

                    $couponDiscount = min($couponDiscount, $subtotal);
                }
            }

            $total = $subtotal - $couponDiscount + $shipping;

            $order = Order::create([
                'customer_id' => auth('customer')->id(),
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2 ?? null,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'delivery_zone' => $request->delivery_zone,
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'shipping_cost' => $shipping,
                'coupon_code' => optional($coupon)->code,
                'discount' => $couponDiscount,
                'total' => $total,
            ]);

            foreach ($cart as $slug => $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'variant_id' => $item['variant_id'] ?? null,
                    'quantity' => $item['quantity'],
                    'price' => !empty($item['discount_price'])
                        ? $item['discount_price']
                        : $item['price'],
                    'size' => $item['size'] ?? null,
                    'color' => $item['color'] ?? null,
                ]);
            }

            if ($coupon) {
                // Increase total usage for the coupon overall
                $coupon->increment('used_count');

                // Track per-user usage manually
                $existing = DB::table('coupon_user')
                    ->where('coupon_id', $coupon->id)
                    ->where('customer_id', auth('customer')->id())
                    ->first();

                if ($existing) {
                    DB::table('coupon_user')
                        ->where('coupon_id', $coupon->id)
                        ->where('customer_id', auth('customer')->id())
                        ->increment('used_count');
                } else {
                    DB::table('coupon_user')->insert([
                        'coupon_id' => $coupon->id,
                        'customer_id' => auth('customer')->id(),
                        'used_count' => 1,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                session()->forget('coupon');
            }

            session()->forget($cartKey);

            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            // dd($e->getMessage(), $e->getTraceAsString());
            Log::error('Order Placement Failed: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while placing your order.');
        }
    }
}
