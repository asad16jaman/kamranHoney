@php
    $setting = \App\Helpers\SettingsHelper::getSetting();
@endphp

<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Kamran Honey | Home Page</title>
    @if ($setting->favicon_image)
        <link rel="shortcut icon" href="{{ asset('uploads/logo_and_icon/' . $setting->favicon_image) }}"
            type="image/x-icon" />
    @else
        <link rel="shortcut icon" href="{{ asset('uploads/no_images/no-image.png') }}" type="image/x-icon" />
    @endif

    <link href="https://fonts.googleapis.com/css?family=Cairo:400,600,700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400i,700i" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Ubuntu&amp;display=swap" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Anek+Bangla:wght@100..800&family=Karla:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.css" />
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets') }}/images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/bootstrap.min.css" />

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/animate.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/nice-select.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/slick.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/style.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/style2.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/main-color.css" />

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    @stack('styles')
</head>

<body class="">

    @include('frontend.partials.header')

    <!-- Page Contain -->
    <div class="page-contain">
        <div id="main-content" class="main-content">

            @yield('content')

        </div>
    </div>

    @include('frontend.partials.cart')

    <div class="offcanvas-overlay"></div>

    @include('frontend.partials.footer')

    <!--Quickview Popup-->
    <div id="biolife-quickview-block" class="biolife-quickview-block">
        <div class="quickview-container">
            <a href="#" class="btn-close-quickview" data-object="open-quickview-block"><span
                    class="biolife-icon icon-close-menu"></span></a>
            <div class="biolife-quickview-inner">
                <div class="media">
                    <ul class="biolife-carousel quickview-for" id="qv-images"></ul>
                    <ul class="biolife-carousel quickview-nav" id="qv-thumbs"></ul>
                </div>
                <div class="product-attribute">
                    <h4 class="title">
                        <a href="#" class="pr-name" id="qv-name"></a>
                    </h4>
                    <div class="rating">
                        <p class="star-rating"><span class="width-80percent"></span></p>
                    </div>

                    <div class="price price-contain" id="qv-price"></div>

                    <p class="excerpt" id="qv-description"></p>

                    <div class="from-cart">
                        <div class="qty-input">
                            <input type="text" name="qty12554" value="1" data-max_value="20" data-min_value="1"
                                data-step="1" />
                            <a href="#" class="qty-btn btn-up"><i class="fa fa-caret-up"
                                    aria-hidden="true"></i></a>
                            <a href="#" class="qty-btn btn-down"><i class="fa fa-caret-down"
                                    aria-hidden="true"></i></a>
                        </div>
                        <div class="buttons">
                            <a href="#" class="btn add-to-cart-btn btn-bold">add to cart</a>
                        </div>
                    </div>

                    <div class="product-meta">
                        <div class="product-atts">
                            <div class="product-atts-item">
                                <b class="meta-title">Categories:</b>
                                <ul class="meta-list">
                                    <li><a href="#" class="meta-link" id="qv-category"></a></li>
                                </ul>
                            </div>
                            <div class="product-atts-item">
                                <b class="meta-title">Brand:</b>
                                <ul class="meta-list">
                                    <li><a href="#" class="meta-link" id="qv-brand"></a></li>
                                </ul>
                            </div>
                        </div>
                        <span class="sku">SKU: N/A</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scroll Top Button -->
    {{-- <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a> --}}

    <script src="{{ asset('frontend/assets') }}/js/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/jquery.countdown.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/jquery.nicescroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/slick.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/biolife.framework.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/functions.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "3000"
        };
    </script>

    {{-- for cart --}}
    <script>
        $(document).ready(function() {

            $("#openOffcanvasDesktop, #openOffcanvasMobile").on("click", function() {
                $("#offcanvasRight").addClass("active");
                $(".offcanvas-overlay").addClass("active");
            });

            $(".close-offcanvas, .offcanvas-overlay").on("click", function() {
                $("#offcanvasRight").removeClass("active");
                $(".offcanvas-overlay").removeClass("active");
            });

        });

        Fancybox.bind("[data-fancybox='gallery']", {
            zoomEffect: false,
            Carousel: {
                gestures: false,
            },
        });
    </script>

    {{-- cart quantity update --}}
    <script>
        $(document).on('click', '.increase', function() {
            let key = $(this).data('key');
            let row = $(this).closest('tr');
            let input = row.find('.qty-input');
            let qty = parseInt(input.val()) + 1;

            updateCartQty(key, qty, row);
        });

        $(document).on('click', '.decrease', function() {
            let key = $(this).data('key');
            let row = $(this).closest('tr');
            let input = row.find('.qty-input');
            let qty = Math.max(1, parseInt(input.val()) - 1);

            updateCartQty(key, qty, row);
        });

        function updateCartQty(key, qty, row) {
            $.ajax({
                url: "{{ route('cart.update') }}",
                method: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    key: key,
                    qty: qty
                },
                success: function(res) {
                    row.find('.qty-input').val(res.qty);
                    row.find('.item-total').text('৳' + res.item_total.toFixed(2));

                    $('#desktop-cart-qty, #mobile-cart-qty').text(res.count);
                    $('#desktop-cart-subtotal, #mobile-cart-subtotal')
                        .text(res.subtotal.toFixed(2) + ' ৳');
                }
            });
        }
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".fade-up-on-scroll");

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("is-visible");
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.2,
                }
            );

            elements.forEach((el) => observer.observe(el));
        });

        document.addEventListener("DOMContentLoaded", function() {
            const video = document.querySelector(".bg-video");
            if (video) {
                video.play().catch(() => {
                    console.log("Autoplay blocked, user interaction needed");
                });
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
