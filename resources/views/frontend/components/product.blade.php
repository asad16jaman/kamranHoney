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
                                <a href="{{ route('product.show', $product->slug) }}" class="link-to-product">
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
                                    data-inventory='@json($product->inventory)' onclick="openQuickView(this)">
                                    <i class="biolife-icon icon-search"></i>
                                </a>
                            </div>

                            <!-- Info -->
                            <div class="info">
                                <h4 class="product-title">
                                    <a href="{{ route('product.show', $product->slug) }}" class="pr-name">
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

@push('scripts')
    <script>
        const ASSET_URL = "{{ asset('') }}";
    </script>

    <script>
        function openQuickView(el) {
            const product = JSON.parse(el.dataset.product);
            let gallery = JSON.parse(el.dataset.gallery || '[]'); // existing gallery
            const inventory = JSON.parse(el.dataset.inventory || '[]');

            // If no gallery images, use thumbnail image
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
                imgHtml += `
        <li>
            <img src="${ASSET_URL}${img}"
                 style="width:351px;height:306px"
                 alt="">
        </li>`;
                thumbHtml += `
        <li>
            <img src="${ASSET_URL}${img}"
                 style="height:50px"
                 alt="">
        </li>`;
            });

            document.getElementById('qv-images').innerHTML = imgHtml;
            document.getElementById('qv-thumbs').innerHTML = thumbHtml;

            // Destroy & reinitialize slick
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

            // Price logic
            let prices = inventory.map(i => i.price);
            let discounts = inventory.filter(i => i.discount_price).map(i => i.discount_price);

            let priceHtml = '';
            if (discounts.length) {
                priceHtml = `
            <ins>৳ ${Math.min(...discounts)} – ৳ ${Math.max(...discounts)}</ins>
            <del>৳ ${Math.min(...prices)} – ৳ ${Math.max(...prices)}</del>
        `;
            } else {
                priceHtml = `<ins>৳ ${Math.min(...prices)} – ৳ ${Math.max(...prices)}</ins>`;
            }
            document.getElementById('qv-price').innerHTML = priceHtml;

            // Open modal
            document.getElementById('biolife-quickview-block').classList.add('open');
        }
    </script>
@endpush
