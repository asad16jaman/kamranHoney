@extends('admin.layouts.master')

@section('title', 'Order Details')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading">
                    <i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    <a href="{{ route('orders.index') }}">Order List</a>
                </span>
            </div>

            <div class="card mb-4">
                <div class="card-header heading-title">
                    <h5>Order Details (Order No: {{ $order->order_number }})</h5>
                </div>
                <div class="card-body">
                    <h6>Customer Info</h6>
                    <table class="table table-bordered">
                        <tr>
                            <th>Name</th>
                            <td>{{ $order->customer?->first_name }} {{ $order->customer?->last_name }}</td>
                            <th>Email</th>
                            <td>{{ $order->customer?->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $order->customer?->phone }}</td>
                            <th>City</th>
                            <td>{{ $order->city }}</td>
                        </tr>
                        <tr>
                            <th>Address 1</th>
                            <td>{{ $order->address_line_1 }}</td>
                            <th>Address 2</th>
                            <td>{{ $order->address_line_2 ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Zip Code</th>
                            <td>{{ $order->zip_code }}</td>
                            <th>Payment Method</th>
                            <td>{{ ucfirst($order->payment_method) }}</td>
                        </tr>
                    </table>

                    <h6 class="mt-4">Order Items</h6>
                    <table class="table table-bordered text-center">
                        <thead class="bg-light">
                            <tr>
                                <th>Product</th>
                                <th>Price (৳)</th>
                                <th>Quantity</th>
                                <th>Size</th>
                                <th>Color</th>
                                <th>Subtotal (৳)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->product->name ?? 'N/A' }}</td>
                                    <td>
                                        @if ($item->product->discount_price)
                                            <span class="text-muted text-decoration-line-through me-2">
                                                {{ $item->product->price }} ৳
                                            </span>
                                            <span class="text-danger fw-bold">
                                                {{ $item->product->discount_price }} ৳
                                            </span>
                                        @else
                                            {{ $item->product->price }} ৳
                                        @endif
                                    </td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->size ?? '-' }}</td>
                                    <td>{{ $item->color ?? '-' }}</td>
                                    <td>{{ $item->price * $item->quantity }} ৳</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <th colspan="5" class="text-end">Subtotal:</th>
                                <th>{{ $order->subtotal }} ৳</th>
                            </tr>

                            @if ($order->coupon_code)
                                <tr class="table-success">
                                    <th colspan="5" class="text-end text-success">Coupon ({{ $order->coupon_code }}):
                                    </th>
                                    <th class="text-success">-{{ $order->discount }} ৳</th>
                                </tr>
                            @endif

                            <tr>
                                <th colspan="5" class="text-end">Shipping Cost:</th>
                                <th>{{ $order->shipping_cost }} ৳</th>
                            </tr>
                            <tr>
                                <th colspan="5" class="text-end">Grand Total:</th>
                                <th>{{ $order->total }} ৳</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
