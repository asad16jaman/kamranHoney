@extends('admin.layouts.master')

@section('title', 'Edit Order')

@section('main-content')
    <main>
        <div class="container-fluid">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading">
                    <i class="fas fa-home"></i>
                    <a href="{{ route('dashboard') }}">Dashboard</a> >
                    <a href="{{ route('orders.index') }}">Order List</a> > Edit Order
                </span>
            </div>

            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card mb-4">
                    <div class="card-header heading-title">
                        <h5>Edit Order (Order No: {{ $order->order_number }})</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead class="bg-light">
                                <tr>
                                    <th>Product</th>
                                    <th>Price (৳)</th>
                                    <th>Quantity</th>
                                    <th>Color</th>
                                    <th>Size</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->items as $index => $item)
                                    @php
                                        $product = $item->product;
                                        $variantSizes = $product->variants->pluck('size')->unique('id')->filter();
                                        $variantColors = $product->variants->pluck('color')->unique('id')->filter();
                                    @endphp
                                    <tr>
                                        <td>
                                            {{ $product->name }}
                                            <input type="hidden" name="items[{{ $index }}][id]"
                                                value="{{ $item->id }}">
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][price]"
                                                value="{{ $item->price }}" class="form-control">
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                value="{{ $item->quantity }}" class="form-control">
                                        </td>
                                        <td>
                                            <select name="items[{{ $index }}][color]" class="form-control">
                                                <option value="">Select Color</option>
                                                @foreach ($variantColors as $color)
                                                    <option value="{{ $color->name }}"
                                                        {{ $item->color == $color->name ? 'selected' : '' }}>
                                                        {{ $color->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <select name="items[{{ $index }}][size]" class="form-control">
                                                <option value="">Select Size</option>
                                                @foreach ($variantSizes as $size)
                                                    <option value="{{ $size->name }}"
                                                        {{ $item->size == $size->name ? 'selected' : '' }}>
                                                        {{ $size->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Order</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection
