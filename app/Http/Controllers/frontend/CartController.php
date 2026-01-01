<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->product_id;
        $unit = $request->unit;
        $price = $request->price;
        $qty = $request->qty;

        $cart = Session::get('cart', []);

        $key = $productId . '-' . $unit;

        if (isset($cart[$key])) {
            $cart[$key]['qty'] += $qty;
        } else {
            $cart[$key] = [
                'product_id' => $productId,
                'unit' => $unit,
                'price' => $price,
                'qty' => $qty,
                'name' => $request->product_name,
                'image' => $request->image ?? 'uploads/no_images/no-image.png',
            ];
        }

        Session::put('cart', $cart);

        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));

        return response()->json([
            'success' => true,
            'count' => $count,
            'subtotal' => $subtotal
        ]);
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);
        $key = $request->key;
        $qty = max(1, (int)$request->qty);

        if (isset($cart[$key])) {
            $cart[$key]['qty'] = $qty;
            session()->put('cart', $cart);
        }

        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));

        return response()->json([
            'count' => $count,
            'subtotal' => $subtotal,
            'item_total' => $cart[$key]['price'] * $cart[$key]['qty'],
            'qty' => $cart[$key]['qty']
        ]);
    }

    public function count()
    {
        $cart = Session::get('cart', []);
        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
        return response()->json([
            'count' => $count,
            'subtotal' => $subtotal
        ]);
    }

    public function data()
    {
        $cart = Session::get('cart', []);
        return view('frontend.partials.cart_data', compact('cart'))->render();
    }

    public function remove(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->key]);
        session()->put('cart', $cart);

        $count = array_sum(array_column($cart, 'qty'));
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));

        $html = view('frontend.partials.cart_data', compact('cart'))->render();

        return response()->json([
            'count' => $count,
            'subtotal' => $subtotal,
            'html' => $html
        ]);
    }
}
