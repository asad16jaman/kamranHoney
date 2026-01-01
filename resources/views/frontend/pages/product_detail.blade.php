@extends('frontend.layouts.master')

@push('styles')
    <style>
        .unit-wrapper {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 6px;
        }

        .unit-btn {
            border: 1px solid #ddd;
            background: #fff;
            padding: 6px 14px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 3px;
            transition: all 0.2s ease;
            width: 100px;
            text-align: center;
        }

        .unit-btn:hover {
            border-color: #7faf51;
            color: #7faf51;
        }

        .unit-btn.active {
            background: #7faf51;
            border-color: #7faf51;
            color: #fff;
        }

        .price del {
            display: inline-block !important;
            margin-left: 8px;
            vertical-align: middle;
        }

        .price del .price-amount {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
        }

        .price ins .price-amount {
            font-size: 18px;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
    <!-- Hero Section -->
    <div class="hero-section hero-background">
        <nav class="biolife-nav nav-86px">
            <ul>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="permal-link">Home</a>
                </li>
                <li class="nav-item">
                    <span class="current-page">Product Details</span>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Page Contain -->
    <div class="page-contain single-product">
        <div class="container mt-30 mb-30">
            <div id="main-content" class="main-content">
                <div class="sumary-product single-layout container-fluid">

                    <div class="media">
                        @php
                            $gallery = json_decode($product->gallery_images, true) ?? [];
                        @endphp

                        <ul class="biolife-carousel slider-for">
                            @if (count($gallery))
                                @foreach ($gallery as $img)
                                    <li>
                                        <img src="{{ asset($img) }}" alt="{{ $product->name }}">
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <img src="{{ asset($product->thumbnail_image ?? 'uploads/no_images/no-image.png') }}"
                                        alt="{{ $product->name }}">
                                </li>
                            @endif
                        </ul>

                        <ul class="biolife-carousel slider-nav">
                            @if (count($gallery))
                                @foreach ($gallery as $img)
                                    <li>
                                        <img src="{{ asset($img) }}" alt="{{ $product->name }}">
                                    </li>
                                @endforeach
                            @else
                                <li>
                                    <img src="{{ asset($product->thumbnail_image ?? 'uploads/no_images/no-image.png') }}"
                                        alt="{{ $product->name }}">
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="product-attribute">
                        <h3 class="title">{{ $product->name }}</h3>

                        <div class="rating">
                            <p class="star-rating"><span class="width-80percent"></span></p>
                            <span class="review-count">(04 Reviews)</span>
                        </div>

                        <p class="excerpt">{{ $product->short_description }}</p>

                        <div class="product-meta">
                            <div class="product-atts w-100 custom-pad">

                                <div class="product-atts-item">
                                    <b class="meta-title">Category:</b>
                                    <ul class="meta-list">
                                        <li>
                                            <a href="#" class="meta-link">{{ $product->category->name ?? 'N/A' }}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="product-atts-item">
                                    <b class="meta-title">Sub Category:</b>
                                    <ul class="meta-list">
                                        <li>
                                            <a href="#"
                                                class="meta-link">{{ $product->subCategory->name ?? 'N/A' }}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="product-atts-item">
                                    <b class="meta-title">Brand:</b>
                                    <ul class="meta-list">
                                        <li>
                                            <a href="#" class="meta-link">{{ $product->client->name ?? 'N/A' }}</a>
                                        </li>
                                    </ul>
                                </div>

                                <div class="product-atts-item">
                                    <div class="unit-wrapper">
                                        @foreach ($product->inventory as $inv)
                                            <button type="button" class="unit-btn" data-price="{{ $inv->price }}"
                                                data-discount="{{ $inv->discount_price }}">
                                                {{ $inv->unit->name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="price mt-3" id="unitPrice" style="display:none;">
                                    <ins>
                                        <span class="price-amount">
                                            <span class="currencySymbol">৳</span>
                                            <span id="finalPrice"></span>
                                        </span>
                                    </ins>

                                    <del id="oldPriceWrapper" style="display:none;">
                                        <span class="price-amount">
                                            <span class="currencySymbol">৳</span>
                                            <span id="oldPrice"></span>
                                        </span>
                                    </del>
                                </div>
                            </div>

                            <div class="from-cart">
                                <div class="qty-input">
                                    <input type="text" name="qty" value="1" data-max_value="20"
                                        data-min_value="1" data-step="1">

                                    <a href="#" class="qty-btn btn-up">
                                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                                    </a>

                                    <a href="#" class="qty-btn btn-down">
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                    </a>
                                </div>
                                <div class="buttons">
                                    <a href="#" class="btn add-to-cart-btn btn-bold">Add to Cart</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- related products -->
                <div class="product-related-box single-layout">
                    <div class="biolife-title-box lg-margin-bottom-26px-im text-center">
                        <h3 class="main-title">Related Products</h3>
                    </div>

                    <ul class="products-list biolife-carousel nav-center-02 nav-none-on-mobile"
                        data-slick='{"rows":1,"arrows":true,"dots":false,"infinite":false,"speed":400,"slidesMargin":35,"slidesToShow":4, "responsive":[{"breakpoint":1200, "settings":{ "slidesToShow": 4}},{"breakpoint":992, "settings":{ "slidesToShow": 3, "slidesMargin":20 }},{"breakpoint":768, "settings":{ "slidesToShow": 2, "slidesMargin":10}}]}'>

                        @forelse($relatedProducts as $related)
                            @php
                                $prices = $related->inventory->pluck('price');
                                $discountPrices = $related->inventory
                                    ->whereNotNull('discount_price')
                                    ->pluck('discount_price');
                            @endphp
                            <li class="product-item">
                                <div class="contain-product layout-default">
                                    <div class="product-thumb">
                                        <a href="{{ route('product.show', $related->slug) }}" class="link-to-product">
                                            <img src="{{ asset($related->thumbnail_image ?? 'uploads/no_images/no-image.png') }}"
                                                alt="{{ $related->name }}" width="270" height="270"
                                                class="product-thumnail">
                                        </a>

                                        @if ($discountPrices->count())
                                            <p class="offer">SALE</p>
                                        @endif

                                        @if ($related->is_hot ?? false)
                                            <p class="attribute">HOT</p>
                                        @endif

                                        <a class="lookup btn_call_quickview" href="javascript:void(0)"
                                            data-product='@json($related)'
                                            data-gallery='@json(json_decode($related->gallery_images, true))'
                                            data-inventory='@json($related->inventory)' onclick="openQuickView(this)">
                                            <i class="biolife-icon icon-search"></i>
                                        </a>
                                    </div>

                                    <div class="info">
                                        <h4 class="product-title">
                                            <a href="{{ route('product.show', $related->slug) }}"
                                                class="pr-name">{{ $related->name }}</a>
                                        </h4>

                                        <div class="price">
                                            @if ($discountPrices->count())
                                                <ins>
                                                    <span class="price-amount">
                                                        <span
                                                            class="currencySymbol">৳</span>{{ number_format($discountPrices->min(), 2) }}
                                                        @if ($discountPrices->min() != $discountPrices->max())
                                                            – ৳{{ number_format($discountPrices->max(), 2) }}
                                                        @endif
                                                    </span>
                                                </ins>
                                                <del>
                                                    <span class="price-amount">
                                                        <span
                                                            class="currencySymbol">৳</span>{{ number_format($prices->min(), 2) }}
                                                        @if ($prices->min() != $prices->max())
                                                            – ৳{{ number_format($prices->max(), 2) }}
                                                        @endif
                                                    </span>
                                                </del>
                                            @else
                                                <ins>
                                                    <span class="price-amount">
                                                        <span
                                                            class="currencySymbol">৳</span>{{ number_format($prices->min(), 2) }}
                                                        @if ($prices->min() != $prices->max())
                                                            – ৳{{ number_format($prices->max(), 2) }}
                                                        @endif
                                                    </span>
                                                </ins>
                                            @endif
                                        </div>

                                        <div class="buttons card-padding">
                                            <a href="#" class="btn add-cart-btn">
                                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                add to cart
                                            </a>
                                            <a href="#" class="btn add-cart-btn buy_now_btn">
                                                <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                Buy Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="col-12 text-center">
                                <p>No related products found.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const unitButtons = document.querySelectorAll('.unit-btn');
        const priceBox = document.getElementById('unitPrice');
        const finalPrice = document.getElementById('finalPrice');
        const oldPrice = document.getElementById('oldPrice');
        const oldWrapper = document.getElementById('oldPriceWrapper');

        unitButtons.forEach(btn => {
            btn.addEventListener('click', function() {

                unitButtons.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const price = this.dataset.price;
                const discount = this.dataset.discount;

                priceBox.style.display = 'block';

                if (discount && discount > 0) {
                    finalPrice.innerText = parseFloat(discount).toFixed(2);
                    oldPrice.innerText = parseFloat(price).toFixed(2);
                    oldWrapper.style.display = 'inline';
                } else {
                    finalPrice.innerText = parseFloat(price).toFixed(2);
                    oldWrapper.style.display = 'none';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const firstUnit = document.querySelector('.unit-btn');
            if (firstUnit) {
                firstUnit.click();
            }
        });
    </script>
@endpush
