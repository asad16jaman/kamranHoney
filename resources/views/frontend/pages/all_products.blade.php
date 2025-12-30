@extends('frontend.layouts.master')

@section('content')
    <div class="page-contain">
        <div id="main-content" class="main-content">
            <!--Hero Section-->
            <div class="hero-section hero-background">
                <nav class="biolife-nav nav-86px">
                    <ul>
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="permal-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <span class="current-page">All Products</span>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="container">
                <div class="row mt-30 mb-30">
                    <!-- Sidebar -->
                    <aside id="sidebar" class="sidebar col-lg-3 col-md-4 col-sm-12 col-xs-12">
                        <div class="biolife-mobile-panels">
                            <span class="biolife-current-panel-title">Sidebar</span>
                            <a class="biolife-close-btn" href="#" data-object="open-mobile-filter">&times;</a>
                        </div>
                        <div class="sidebar-contain">

                            <div class="widget biolife-filter">
                                <h4 class="wgt-title">All Categories</h4>
                                <div class="wgt-content">
                                    <ul class="cat-list">
                                        @php
                                            $categories = \App\Models\Category::where('status', 'a')->latest()->get();
                                        @endphp
                                        @foreach ($categories as $category)
                                            <li class="cat-list-item">
                                                <a href="{{ route('all.products') }}?category={{ $category->id }}"
                                                    class="cat-link">
                                                    {{ $category->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>

                            <div class="widget biolife-filter">
                                <h4 class="wgt-title">Sub Categories</h4>
                                <div class="wgt-content">
                                    <ul class="cat-list">
                                        @foreach ($categories as $category)
                                            @foreach ($category->subCategories()->where('status', 'a')->get() as $sub)
                                                <li class="cat-list-item">
                                                    <a href="{{ route('all.products') }}?subcategory={{ $sub->id }}"
                                                        class="cat-link">
                                                        {{ $sub->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- Main content -->
                    <div id="main-content" class="main-content col-lg-9 col-md-8 col-sm-12 col-xs-12">
                        <div class="product-category grid-style">
                            <div class="row">

                                @forelse ($products as $product)
                                    @php
                                        $prices = $product->inventory->pluck('price');
                                        $discountPrices = $product->inventory
                                            ->whereNotNull('discount_price')
                                            ->pluck('discount_price');
                                    @endphp

                                    <div class="col-lg-4 col-md-6 mb-3">
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

                                                    <a class="lookup btn_call_quickview" href="javascript:void(0)"
                                                        data-product='@json($product)'
                                                        data-gallery='@json(json_decode($product->gallery_images, true))'
                                                        data-inventory='@json($product->inventory)'
                                                        onclick="openQuickView(this)">
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
                                                                            –
                                                                            ৳{{ number_format($discountPrices->max(), 2) }}
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

                            @if (method_exists($products, 'links'))
                                <div class="biolife-panigations-block mt-30">
                                    {{ $products->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const ASSET_URL = "{{ asset('') }}";
    </script>

    <script>
        function openQuickView(el) {
            const product = JSON.parse(el.dataset.product);
            let gallery = JSON.parse(el.dataset.gallery || '[]');
            const inventory = JSON.parse(el.dataset.inventory || '[]');

            if (!gallery.length && product.thumbnail_image) {
                gallery.push(product.thumbnail_image);
            }

            document.getElementById('qv-name').innerText = product.name;
            document.getElementById('qv-description').innerText = product.short_description ?? '';
            document.getElementById('qv-category').innerText = product.category?.name ?? '';
            document.getElementById('qv-brand').innerText = product.client?.name ?? '';

            let imgHtml = '';
            let thumbHtml = '';

            gallery.forEach(img => {
                imgHtml += `<li><img src="${ASSET_URL}${img}" style="width:351px;height:306px" alt=""></li>`;
                thumbHtml += `<li><img src="${ASSET_URL}${img}" style="height:50px" alt=""></li>`;
            });

            document.getElementById('qv-images').innerHTML = imgHtml;
            document.getElementById('qv-thumbs').innerHTML = thumbHtml;

            if ($('#qv-images').hasClass('slick-initialized')) {
                $('#qv-images').slick('unslick');
            }
            if ($('#qv-thumbs').hasClass('slick-initialized')) {
                $('#qv-thumbs').slick('unslick');
            }

            $('#qv-images').slick({
                arrows: false,
                dots: false,
                slidesToShow: 1,
                slidesToScroll: 1,
                fade: true,
                asNavFor: '#qv-thumbs'
            });

            $('#qv-thumbs').slick({
                arrows: true,
                dots: false,
                slidesToShow: 3,
                slidesToScroll: 1,
                focusOnSelect: true,
                asNavFor: '#qv-images'
            });

            let prices = inventory.map(i => i.price);
            let discounts = inventory.filter(i => i.discount_price).map(i => i.discount_price);

            let priceHtml = '';
            if (discounts.length) {
                priceHtml = `<ins>৳ ${Math.min(...discounts)} – ৳ ${Math.max(...discounts)}</ins>
                     <del>৳ ${Math.min(...prices)} – ৳ ${Math.max(...prices)}</del>`;
            } else {
                priceHtml = `<ins>৳ ${Math.min(...prices)} – ৳ ${Math.max(...prices)}</ins>`;
            }
            document.getElementById('qv-price').innerHTML = priceHtml;

            document.getElementById('biolife-quickview-block').classList.add('open');
        }
    </script>
@endpush
