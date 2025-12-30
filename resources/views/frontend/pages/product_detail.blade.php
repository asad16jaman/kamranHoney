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
                <div class="sumary-product single-layout">

                    <div class="media">
                        <ul class="biolife-carousel slider-for"
                            data-slick='{"arrows":false,"dots":false,"slidesToShow":1,"fade":true,"asNavFor":".slider-nav"}'>

                            @php
                                $gallery = json_decode($product->gallery_images, true) ?? [];
                            @endphp

                            @forelse ($gallery as $img)
                                <li>
                                    <img src="{{ asset($img) }}" alt="{{ $product->name }}"
                                        style="width:500px;height:400px;">
                                </li>
                            @empty
                                <li>
                                    <img src="{{ asset($product->thumbnail_image ?? 'uploads/no_images/no-image.png') }}"
                                        alt="{{ $product->name }}" style="width:500px;height:400px;">
                                </li>
                            @endforelse
                        </ul>

                        <ul class="biolife-carousel slider-nav"
                            data-slick='{"arrows":false,"dots":false,"slidesToShow":4,"asNavFor":".slider-for"}'>
                            @foreach ($gallery as $img)
                                <li>
                                    <img src="{{ asset($img) }}" alt="{{ $product->name }}"
                                        style="width:88px;height:88px;">
                                </li>
                            @endforeach
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

                <!-- Tab info -->
                <div class="product-tabs single-layout biolife-tab-contain">
                    <div class="tab-head">
                        <ul class="tabs">
                            <li class="tab-element active"><a href="#tab_1st" class="tab-link">Products Descriptions</a>
                            </li>

                            <li class="tab-element"><a href="#tab_3rd" class="tab-link">Shipping & Delivery</a></li>
                            <li class="tab-element"><a href="#tab_4th" class="tab-link">Customer Reviews
                                    <sup>(3)</sup></a></li>
                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="tab_1st" class="tab-contain desc-tab active">
                            <p class="desc">{{ $product->description ?? 'No description available.' }}</p>
                        </div>

                        <div id="tab_3rd" class="tab-contain shipping-delivery-tab">
                            <div class="accodition-tab biolife-accodition">
                                <ul class="tabs">
                                    <li class="tab-item">
                                        <span class="title btn-expand">How long will it take to receive my
                                            order?</span>
                                        <div class="content">
                                            <p>Orders placed before 3pm eastern time will normally be processed and
                                                shipped by the following business day. For orders received after 3pm,
                                                they will generally be processed and shipped on the second business day.
                                                For example if you place your order after 3pm on Monday the order will
                                                ship on Wednesday. Business days do not include Saturday and Sunday and
                                                all Holidays. Please allow additional processing time if you order is
                                                placed on a weekend or holiday. Once an order is processed, speed of
                                                delivery will be determined as follows based on the shipping mode
                                                selected:</p>
                                            <div class="desc-expand">
                                                <span class="title">Shipping mode</span>
                                                <ul class="list">
                                                    <li>Standard (in transit 3-5 business days)</li>
                                                    <li>Priority (in transit 2-3 business days)</li>
                                                    <li>Express (in transit 1-2 business days)</li>
                                                    <li>Gift Card Orders are shipped via USPS First Class Mail. First
                                                        Class mail will be delivered within 8 business days</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="tab-item">
                                        <span class="title btn-expand">How is the shipping cost calculated?</span>
                                        <div class="content">
                                            <p>You will pay a shipping rate based on the weight and size of the order.
                                                Large or heavy items may include an oversized handling fee. Total
                                                shipping fees are shown in your shopping cart. Please refer to the
                                                following shipping table:</p>
                                            <p>Note: Shipping weight calculated in cart may differ from weights listed
                                                on product pages due to size and actual weight of the item.</p>
                                        </div>
                                    </li>
                                    <li class="tab-item">
                                        <span class="title btn-expand">Why Didn’t My Order Qualify for FREE
                                            shipping?</span>
                                        <div class="content">
                                            <p>We do not deliver to P.O. boxes or military (APO, FPO, PSC) boxes. We
                                                deliver to all 50 states plus Puerto Rico. Certain items may be excluded
                                                for delivery to Puerto Rico. This will be indicated on the product page.
                                            </p>
                                        </div>
                                    </li>
                                    <li class="tab-item">
                                        <span class="title btn-expand">Shipping Restrictions?</span>
                                        <div class="content">
                                            <p>We do not deliver to P.O. boxes or military (APO, FPO, PSC) boxes. We
                                                deliver to all 50 states plus Puerto Rico. Certain items may be excluded
                                                for delivery to Puerto Rico. This will be indicated on the product page.
                                            </p>
                                        </div>
                                    </li>
                                    <li class="tab-item">
                                        <span class="title btn-expand">Undeliverable Packages?</span>
                                        <div class="content">
                                            <p>Occasionally packages are returned to us as undeliverable by the carrier.
                                                When the carrier returns an undeliverable package to us, we will cancel
                                                the order and refund the purchase price less the shipping charges. Here
                                                are a few reasons packages may be returned to us as undeliverable:</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div id="tab_4th" class="tab-contain review-tab">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12">
                                        <div class="rating-info">
                                            <p class="index"><strong class="rating">4.4</strong>out of 5</p>
                                            <div class="rating">
                                                <p class="star-rating"><span class="width-80percent"></span></p>
                                            </div>
                                            <p class="see-all">See all 68 reviews</p>
                                            <ul class="options">
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">5stars</span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span
                                                                    class="percent width-90percent"></span></span>
                                                        </span>
                                                        <span class="number">90</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">4stars</span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span
                                                                    class="percent width-30percent"></span></span>
                                                        </span>
                                                        <span class="number">30</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">3stars</span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span
                                                                    class="percent width-40percent"></span></span>
                                                        </span>
                                                        <span class="number">40</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">2stars</span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span
                                                                    class="percent width-20percent"></span></span>
                                                        </span>
                                                        <span class="number">20</span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="detail-for">
                                                        <span class="option-name">1star</span>
                                                        <span class="progres">
                                                            <span class="line-100percent"><span
                                                                    class="percent width-10percent"></span></span>
                                                        </span>
                                                        <span class="number">10</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12">
                                        <div class="review-form-wrapper">
                                            <span class="title">Submit your review</span>
                                            <form action="#" name="frm-review" method="post">
                                                <div class="comment-form-rating">
                                                    <label>1. Your rating of this products:</label>
                                                    <p class="stars">
                                                        <span>
                                                            <a class="btn-rating" data-value="star-1" href="#"><i
                                                                    class="fa fa-star-o" aria-hidden="true"></i></a>
                                                            <a class="btn-rating" data-value="star-2" href="#"><i
                                                                    class="fa fa-star-o" aria-hidden="true"></i></a>
                                                            <a class="btn-rating" data-value="star-3" href="#"><i
                                                                    class="fa fa-star-o" aria-hidden="true"></i></a>
                                                            <a class="btn-rating" data-value="star-4" href="#"><i
                                                                    class="fa fa-star-o" aria-hidden="true"></i></a>
                                                            <a class="btn-rating" data-value="star-5" href="#"><i
                                                                    class="fa fa-star-o" aria-hidden="true"></i></a>
                                                        </span>
                                                    </p>
                                                </div>
                                                <p class="form-row wide-half">
                                                    <input type="text" name="name" value=""
                                                        placeholder="Your name">
                                                </p>
                                                <p class="form-row wide-half">
                                                    <input type="email" name="email" value=""
                                                        placeholder="Email address">
                                                </p>
                                                <p class="form-row">
                                                    <textarea name="comment" id="txt-comment" cols="30" rows="10" placeholder="Write your review here..."></textarea>
                                                </p>
                                                <p class="form-row">
                                                    <button type="submit" name="submit">submit review</button>
                                                </p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div id="comments">
                                    <ol class="commentlist">
                                        <li class="review">
                                            <div class="comment-container">
                                                <div class="row">
                                                    <div class="comment-content col-lg-8 col-md-9 col-sm-8 col-xs-12">
                                                        <p class="comment-in"><span class="post-name">Quality is our
                                                                way
                                                                of life</span><span class="post-date">01/04/2018</span>
                                                        </p>
                                                        <div class="rating">
                                                            <p class="star-rating"><span class="width-80percent"></span>
                                                            </p>
                                                        </div>
                                                        <p class="author">by: <b>Shop organic</b></p>
                                                        <p class="comment-text">There are few things in life that
                                                            please
                                                            people more than the succulence of quality fresh fruit and
                                                            vegetables. At Fresh Fruits we work to deliver the world’s
                                                            freshest, choicest, and juiciest produce to discerning
                                                            customers across the UAE and GCC.</p>
                                                    </div>
                                                    <div
                                                        class="comment-review-form col-lg-3 col-lg-offset-1 col-md-3 col-sm-4 col-xs-12">
                                                        <span class="title">Was this review helpful?</span>
                                                        <ul class="actions">
                                                            <li><a href="#" class="btn-act like"
                                                                    data-type="like"><i class="fa fa-thumbs-up"
                                                                        aria-hidden="true"></i>Yes (100)</a></li>
                                                            <li><a href="#" class="btn-act hate"
                                                                    data-type="dislike"><i class="fa fa-thumbs-down"
                                                                        aria-hidden="true"></i>No (20)</a></li>
                                                            <li><a href="#" class="btn-act report"
                                                                    data-type="dislike"><i class="fa fa-flag"
                                                                        aria-hidden="true"></i>Report</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="review">
                                            <div class="comment-container">
                                                <div class="row">
                                                    <div class="comment-content col-lg-8 col-md-9 col-sm-8 col-xs-12">
                                                        <p class="comment-in"><span class="post-name">Quality is our
                                                                way
                                                                of life</span><span class="post-date">01/04/2018</span>
                                                        </p>
                                                        <div class="rating">
                                                            <p class="star-rating"><span class="width-80percent"></span>
                                                            </p>
                                                        </div>
                                                        <p class="author">by: <b>Shop organic</b></p>
                                                        <p class="comment-text">There are few things in life that
                                                            please
                                                            people more than the succulence of quality fresh fruit and
                                                            vegetables. At Fresh Fruits we work to deliver the world’s
                                                            freshest, choicest, and juiciest produce to discerning
                                                            customers across the UAE and GCC.</p>
                                                    </div>
                                                    <div
                                                        class="comment-review-form col-lg-3 col-lg-offset-1 col-md-3 col-sm-4 col-xs-12">
                                                        <span class="title">Was this review helpful?</span>
                                                        <ul class="actions">
                                                            <li><a href="#" class="btn-act like"
                                                                    data-type="like"><i class="fa fa-thumbs-up"
                                                                        aria-hidden="true"></i>Yes (100)</a></li>
                                                            <li><a href="#" class="btn-act hate"
                                                                    data-type="dislike"><i class="fa fa-thumbs-down"
                                                                        aria-hidden="true"></i>No (20)</a></li>
                                                            <li><a href="#" class="btn-act report"
                                                                    data-type="dislike"><i class="fa fa-flag"
                                                                        aria-hidden="true"></i>Report</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="review">
                                            <div class="comment-container">
                                                <div class="row">
                                                    <div class="comment-content col-lg-8 col-md-9 col-sm-8 col-xs-12">
                                                        <p class="comment-in"><span class="post-name">Quality is our
                                                                way
                                                                of life</span><span class="post-date">01/04/2018</span>
                                                        </p>
                                                        <div class="rating">
                                                            <p class="star-rating"><span class="width-80percent"></span>
                                                            </p>
                                                        </div>
                                                        <p class="author">by: <b>Shop organic</b></p>
                                                        <p class="comment-text">There are few things in life that
                                                            please
                                                            people more than the succulence of quality fresh fruit and
                                                            vegetables. At Fresh Fruits we work to deliver the world’s
                                                            freshest, choicest, and juiciest produce to discerning
                                                            customers across the UAE and GCC.</p>
                                                    </div>
                                                    <div
                                                        class="comment-review-form col-lg-3 col-lg-offset-1 col-md-3 col-sm-4 col-xs-12">
                                                        <span class="title">Was this review helpful?</span>
                                                        <ul class="actions">
                                                            <li><a href="#" class="btn-act like"
                                                                    data-type="like"><i class="fa fa-thumbs-up"
                                                                        aria-hidden="true"></i>Yes (100)</a></li>
                                                            <li><a href="#" class="btn-act hate"
                                                                    data-type="dislike"><i class="fa fa-thumbs-down"
                                                                        aria-hidden="true"></i>No (20)</a></li>
                                                            <li><a href="#" class="btn-act report"
                                                                    data-type="dislike"><i class="fa fa-flag"
                                                                        aria-hidden="true"></i>Report</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ol>
                                    <div class="biolife-panigations-block version-2">
                                        <ul class="panigation-contain">
                                            <li><span class="current-page">1</span></li>
                                            <li><a href="#" class="link-page">2</a></li>
                                            <li><a href="#" class="link-page">3</a></li>
                                            <li><span class="sep">....</span></li>
                                            <li><a href="#" class="link-page">20</a></li>
                                            <li><a href="#" class="link-page next"><i class="fa fa-angle-right"
                                                        aria-hidden="true"></i></a></li>
                                        </ul>
                                        <div class="result-count">
                                            <p class="txt-count"><b>1-5</b> of <b>126</b> reviews</p>
                                            <a href="#" class="link-to">See all<i class="fa fa-caret-right"
                                                    aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- related products -->
                <div class="product-related-box single-layout">
                    <div class="biolife-title-box lg-margin-bottom-26px-im">
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
