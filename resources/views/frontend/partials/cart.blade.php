<div id="offcanvasRight" class="offcanvas-right">
    <div class="offcanvas-header">
        <h4>Shopping cart</h4>
        <button class="close-offcanvas">&times; Close</button>
    </div>

    <div class="offcanvas-body" id="cart-body">
        @include('frontend.partials.cart_data', ['cart' => session('cart', [])])
    </div>
</div>
