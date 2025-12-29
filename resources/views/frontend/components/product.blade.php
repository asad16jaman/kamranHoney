<!--Product-->
<div class="product-tab z-index-20 sm-margin-top-193px xs-margin-top-30px">
    <div class="container mt-30">

        <div class="biolife-title-box mb-30">
            <div class="g-img">
                <h3 class="main-title cmb-5">Our Products</h3>
            </div>
        </div>

        <div class="row xs-margin-top-30px">

            @forelse ($products as $product)
                @php
                    $prices = $product->inventory->pluck('price');
                    $discountPrices = $product->inventory->whereNotNull('discount_price')->pluck('discount_price');
                @endphp

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="product-item fade-up-on-scroll">
                        <div class="contain-product layout-default">

                            <!-- Thumbnail -->
                            <div class="product-thumb">
                                <a href="#" class="link-to-product">
                                    <img src="{{ asset($product->thumbnail_image ?? 'uploads/no_images/no-image.png') }}"
                                        alt="{{ $product->name }}" width="270" height="270"
                                        class="product-thumnail">
                                </a>

                                {{-- Discount badge --}}
                                @if ($discountPrices->count())
                                    <p class="offer">SALE</p>
                                @endif

                                @if ($product->is_hot ?? false)
                                    <p class="attribute">HOT</p>
                                @endif

                                <a class="lookup btn_call_quickview" href="#" title="Quick View">
                                    <i class="biolife-icon icon-search"></i>
                                </a>
                            </div>

                            <!-- Info -->
                            <div class="info">
                                <h4 class="product-title">
                                    <a href="#" class="pr-name">
                                        {{ $product->name }}
                                    </a>
                                </h4>

                                <!-- Price -->
                                <div class="price">
                                    @if ($discountPrices->count())
                                        <div>
                                            <ins class="d-block">
                                                <span class="price-amount">
                                                    <span class="currencySymbol">৳</span>
                                                    {{ number_format($discountPrices->min(), 2) }}
                                                    @if ($discountPrices->min() != $discountPrices->max())
                                                        – ৳{{ number_format($discountPrices->max(), 2) }}
                                                    @endif
                                                </span>
                                            </ins>
                                        </div>

                                        <div class="mt-1">
                                            <del class="d-block text-muted">
                                                <span class="price-amount">
                                                    <span class="currencySymbol">৳</span>
                                                    {{ number_format($prices->min(), 2) }}
                                                    @if ($prices->min() != $prices->max())
                                                        – ৳{{ number_format($prices->max(), 2) }}
                                                    @endif
                                                </span>
                                            </del>
                                        </div>
                                    @else
                                        <ins class="d-block">
                                            <span class="price-amount">
                                                <span class="currencySymbol">৳</span>
                                                {{ number_format($prices->min(), 2) }}
                                                @if ($prices->min() != $prices->max())
                                                    – ৳{{ number_format($prices->max(), 2) }}
                                                @endif
                                            </span>
                                        </ins>
                                    @endif

                                </div>

                                <!-- Buttons -->
                                <div class="buttons card-padding">
                                    <a href="#" class="btn add-cart-btn">
                                        <i class="fa fa-cart-arrow-down"></i>
                                        Add to Cart
                                    </a>

                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                        <i class="fa fa-cart-arrow-down"></i>
                                        Buy Now
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>No products found.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>
