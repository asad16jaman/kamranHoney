@php
    $count = array_sum(array_column($cart, 'qty'));
    $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['qty'], $cart));
@endphp

<style>
    .qty-box {
        gap: 6px;
    }

    .qty-btn {
        width: 26px;
        height: 26px;
        border: 1px solid #ccc;
        background: #fff;
        cursor: pointer;
        font-weight: bold;
    }

    .qty-input {
        width: 40px;
        text-align: center;
        border: 1px solid #ddd;
    }

    .cart-table td {
        padding: 3px !important;
    }
</style>

{{-- @if (count($cart))
    <table class="table table-light table-borderless table-hover text-center mb-0 cart-table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Unit</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $key => $item)
                <tr data-key="{{ $key }}">
                    <td class="text-start">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset($item['image'] ?? 'uploads/no_images/no-image.png') }}"
                                alt="{{ $item['name'] }}" width="40" height="40"
                                style="object-fit: cover; border-radius: 4px;">
                        </div>
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['unit'] }}</td>
                    <td>৳{{ number_format($item['price'], 2) }}</td>

                    <td>
                        <div class="qty-box d-flex justify-content-center align-items-center">
                            <button class="qty-btn decrease" data-key="{{ $key }}">−</button>
                            <input type="text" class="qty-input" value="{{ $item['qty'] }}" readonly>
                            <button class="qty-btn increase" data-key="{{ $key }}">+</button>
                        </div>
                    </td>

                    <td class="item-total">
                        ৳{{ number_format($item['price'] * $item['qty'], 2) }}
                    </td>

                    <td>
                        <button class="btn btn-sm btn-danger remove-cart-item" data-key="{{ $key }}">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-12 text-right">
            <h5>Subtotal: <strong>৳{{ number_format($subtotal, 2) }}</strong></h5>
        </div>
    </div>

    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-12">
            <button type="button" class="btn btn-success btn-lg btn-block text-center">
                <i class="fa fa-credit-card"></i> Checkout
            </button>
        </div>
    </div>
@else
    <p class="text-center">Your cart is empty.</p>
@endif --}}

@if (count($cart))
    <table class="table table-light table-borderless table-hover text-center mb-0 cart-table">
        <thead>
            <tr>
                <th class="hidden-xs">Image</th> 
                <th>Product</th>
                <th class="hidden-xs">Unit</th>
                <th>Price</th>
                <th>Qty</th>
                <th class="hidden-xs">Total</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $key => $item)
                <tr data-key="{{ $key }}">
                    <td class="text-start hidden-xs">
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ asset($item['image'] ?? 'uploads/no_images/no-image.png') }}"
                                alt="{{ $item['name'] }}" width="40" height="40"
                                style="object-fit: cover; border-radius: 4px;">
                        </div>
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td class="hidden-xs">{{ $item['unit'] }}</td>
                    <td>৳{{ number_format($item['price'], 2) }}</td>

                    <td>
                        <div class="qty-box d-flex justify-content-center align-items-center">
                            <button class="qty-btn decrease" data-key="{{ $key }}">−</button>
                            <input type="text" class="qty-input" value="{{ $item['qty'] }}" readonly>
                            <button class="qty-btn increase" data-key="{{ $key }}">+</button>
                        </div>
                    </td>

                    <td class="item-total hidden-xs">
                        ৳{{ number_format($item['price'] * $item['qty'], 2) }}
                    </td>

                    <td>
                        <button class="btn btn-sm btn-danger remove-cart-item" data-key="{{ $key }}">
                            <i class="fa fa-times"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-12 text-right">
            <h5>Subtotal: <strong>৳{{ number_format($subtotal, 2) }}</strong></h5>
        </div>
    </div>

    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-12">
            <button type="button" class="btn btn-success btn-lg btn-block text-center">
                <i class="fa fa-credit-card"></i> Checkout
            </button>
        </div>
    </div>
@else
    <p class="text-center">Your cart is empty.</p>
@endif

