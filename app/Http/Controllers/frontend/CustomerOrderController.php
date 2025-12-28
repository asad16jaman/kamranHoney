<?php

namespace App\Http\Controllers\frontend;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    public function myOrders()
    {
        $customer = auth('customer')->user();

        $orders = Order::with('items.product')
            ->where('customer_id', $customer->id)
            ->latest()
            ->paginate(10);

        return view('frontend.pages.orders', compact('orders', 'customer'));
    }

    public function show($id)
    {
        $order = Order::with(['items.product'])
            ->where('customer_id', Auth::guard('customer')->id())
            ->findOrFail($id);

        return view('frontend.pages.show', compact('order'));
    }

    public function trackOrderForm()
    {
        try {
            return view('frontend.pages.track_order');
        } catch (\Exception $e) {
            Log::error('Track Order Form Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while loading the track order form.');
        }
    }

    public function trackOrderResult(Request $request)
    {
        try {
            $request->validate([
                'order_number' => 'required|string',
            ]);

            $order = Order::where('order_number', $request->order_number)->first();

            if (! $order) {
                return back()->with('error', 'Order not found. Please check your order number.');
            }

            return view('frontend.pages.track_order_result', compact('order'));
        } catch (\Exception $e) {
            Log::error('Track Order Result Error: ' . $e->getMessage());
            return back()->with('error', 'Something went wrong while tracking your order. Please try again later.');
        }
    }

    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('customer_id', auth('customer')->id())
            ->firstOrFail();

        if (in_array($order->status, ['a', 'c'])) {
            return redirect()->back()->with('error', 'This order cannot be cancelled.');
        }

        $order->status = 'd';
        $order->save();

        return redirect()->back()->with('success', 'Order has been cancelled successfully.');
    }
}
