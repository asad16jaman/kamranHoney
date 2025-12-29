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

                                @if ($product->discount_price)
                                    <p class="offer">
                                        -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </p>
                                @endif

                                @if ($product->is_hot ?? false)
                                    <p class="attribute">HOT</p>
                                @endif

                                <a class="lookup btn_call_quickview"
                                    href="#" title="Quick View">
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

                                <div class="price">
                                    @if ($product->discount_price)
                                        <ins>
                                            <span class="price-amount">
                                                <span class="currencySymbol">৳</span>
                                                {{ number_format($product->discount_price, 2) }}
                                            </span>
                                        </ins>
                                        <del>
                                            <span class="price-amount">
                                                <span class="currencySymbol">৳</span>
                                                {{ number_format($product->price, 2) }}
                                            </span>
                                        </del>
                                    @else
                                        <ins>
                                            <span class="price-amount">
                                                <span class="currencySymbol">৳</span>
                                                {{ number_format($product->price, 2) }}
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
