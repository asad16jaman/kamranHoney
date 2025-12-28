<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Order::with(['items', 'customer']);

            if ($request->has('status')) {
                $query->where('status', $request->status);
            }

            $orders = $query->latest()->paginate(20);

            return view('admin.orders.index', compact('orders'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading the orders index page: ' . $e->getMessage());
            return redirect()->route('dashboard')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function show($id)
    {
        try {
            $order = Order::with(['items.product', 'customer'])->findOrFail($id);
            return view('admin.orders.show', compact('order'));
        } catch (\Exception $e) {
            Log::error('Error occurred while loading order details for order ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('orders.index')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }

    public function edit($id)
    {
        try {
            $order = Order::with(['items.product.variants.size', 'items.product.variants.color'])->findOrFail($id);

            return view('admin.orders.edit', compact('order'));
        } catch (\Exception $e) {
            Log::error("Error loading edit view for order ID $id: " . $e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Failed to load order edit page.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);

            $subtotal = 0;

            foreach ($request->items as $itemData) {
                $orderItem = OrderItem::findOrFail($itemData['id']);

                $orderItem->update([
                    'price' => $itemData['price'],
                    'quantity' => $itemData['quantity'],
                    'size' => $itemData['size'],
                    'color' => $itemData['color'],
                ]);

                $subtotal += $itemData['price'] * $itemData['quantity'];
            }

            $discount = $order->discount ?? 0;
            $shipping = $order->shipping_cost ?? 0;

            $total = $subtotal - $discount + $shipping;

            $order->update([
                'subtotal' => $subtotal,
                'total' => $total,
            ]);

            return redirect()->route('orders.index')->with('success', 'Order updated successfully.');
        } catch (\Exception $e) {
            Log::error("Failed to update order ID $id: " . $e->getMessage());
            return redirect()->back()->with('error', 'Something went wrong while updating.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $order = Order::with('items')->findOrFail($id);

            if ($order->status === 'c') {
                return back()->with('error', 'Completed orders cannot be modified.');
            }

            $request->validate([
                'status' => 'required|in:a,d,p,c',
            ]);

            if ($request->status === 'a' && $order->status !== 'a') {
                foreach ($order->items as $item) {
                    $variant = $item->variant;

                    if (!$variant) {
                        return back()->with('error', "Variant not found for order item #{$item->id}");
                    }

                    if ($variant->stock < $item->quantity) {
                        return back()->with('error', "Not enough stock for “{$item->product->name}”");
                    }

                    $variant->decrement('stock', $item->quantity);
                }
            }

            $order->status = $request->status;
            $order->save();

            return back()->with('success', 'Order status updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while updating order status: ' . $e->getMessage());
            return back()->with('error', 'An unexpected error occurred while updating the status. Please try again later.');
        }
    }

    public function updateTracking(Request $request, $id)
    {
        try {
            $request->validate([
                'tracking_number' => 'nullable|string|max:255',
                'shipping_carrier' => 'nullable|string|max:255',
            ]);

            $order = Order::findOrFail($id);
            $order->tracking_number = $request->tracking_number;
            $order->shipping_carrier = $request->shipping_carrier;
            $order->save();

            return back()->with('success', 'Tracking information updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating tracking info: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating tracking info.');
        }
    }

    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);

            $order->items()->delete();

            $order->delete();

            return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error occurred while deleting order with ID ' . $id . ': ' . $e->getMessage());
            return redirect()->route('orders.index')->with('error', 'An unexpected error occurred. Please try again later.');
        }
    }
}
