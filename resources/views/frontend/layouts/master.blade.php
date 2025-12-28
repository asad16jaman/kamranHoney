<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Kamran Honey | Home Page</title>
    <link rel="shortcut icon" href="{{ asset('frontend/assets') }}/images/logo.jpg" type="image/x-icon" />

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
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets') }}/css/main-color.css" />
    <style>
        /* //navbar css */
        .align-items-center {
            display: flex;
            align-items: center;
        }

        /* Navbar css end */
        .product-item {
            box-shadow: 0px 0px 1px 2px #0000001f;
            margin-bottom: 30px;
        }

        .card-padding {
            padding: 0 10px;
            display: flex;
            justify-content: space-around;
        }

        .add-cart-btn {
            background: #e17f26;
            color: #fff;
            text-transform: uppercase;
            font-weight: 600;
            font-size: 11px;
            border-radius: 25px;
            margin-bottom: 5px;
            width: 102px;
            transition: 0.35s ease-in-out;
        }

        .add-cart-btn:hover {
            color: #e17f26;
            border: 1px solid #e17f26;
            background-color: #fff !important;
        }

        .buy_now_btn {
            background-color: #21854d;
        }

        .buy_now_btn:hover {
            color: #21854d;
            border: 1px solid #21854d;
            background-color: #fff;
        }

        .product-item {
            transition: transform 0.2s ease, box-shadow 0.3s ease;
        }

        .product-item:hover {
            transform: translateY(-10px) scale(1.02) !important;
            /* transform:  !important; */
        }

        .mb-60 {
            margin-bottom: 60px;
        }

        .offer {
            background-color: #e17f26;
            z-index: 9999;
            position: absolute;
            top: 9px;
            /* left: 0; */
            width: 38px;
            height: 25px;
            right: 1px;
            color: #ffffff;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
        }

        .attribute {
            top: 38px;
            position: absolute;
            right: 1px;
            background: red;
            width: 37px;
            height: 24px;
            font-size: 13px;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 4px;
        }

        .product-thumnail {
            width: 100%;
            min-height: 240px;
        }

        .cat-thumnail {
            width: 100%;
            height: 120px;
        }

        .p-2 {
            padding: 10px;
        }

        .socials {
            list-style: none;
        }

        .socials li {
            width: 100%;
            background-color: #21854d;
        }

        .socials li i {
            font-size: 19px;
            padding: 0px 15px;
            color: #fff;
        }

        .socail-btn {
            color: #fff !important;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: inherit;
            font-weight: 500;
            line-height: 1.1;
            color: #302b2b;
        }

        .pr-0 {
            padding-right: 0px !important;
        }

        .b-font {
            font-family: "Anek Bangla", Sans-serif;
        }

        /* offcanvas css start */
        .offcanvas-right {
            position: fixed;
            top: 0;
            right: -450px;
            width: 450px;
            height: 100%;
            background: #fff;
            z-index: 1050;
            transition: right 0.3s ease;
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .offcanvas-right.active {
            right: 0;
        }

        .offcanvas-header {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .offcanvas-body {
            padding: 15px;
        }

        .close-offcanvas {
            background: none;
            border: none;
            font-size: 24px;
            float: right;
            cursor: pointer;
        }

        .offcanvas-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            z-index: 1049;
        }

        .offcanvas-overlay.active {
            display: block;
        }

        /* offcanvas css start */

        /* review card css */
        .review-card {
            background: #fff;
            border: 1px solid #787474;
            padding: 20px;
            border-radius: 4px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .review-card:hover {
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        }

        .review-text {
            font-size: 14px;
            color: #101010;
            line-height: 24px;
            margin-bottom: 20px;
        }

        .review-footer {
            display: flex;
            align-items: center;
        }

        .review-footer img {
            width: 50px;
            height: 50px;
        }

        .review-info {
            margin-left: 10px;
        }

        .review-info h5 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }

        .review-info span {
            font-size: 12px;
            color: #888;
        }

        /* review card css */
        .mb-4 {
            margin-bottom: 30px;
        }

        .d-none {
            display: none;
        }

        .overlay-container-left {
            position: relative;
            height: 550px;
            width: 100%;
        }

        .overlay-container {
            position: relative;
            height: 164px;
            width: 100%;
        }

        .overlay {
            position: absolute;
            background: #e17f267a;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            scale: 0;
            transition: 0.35s ease-in-out;
        }

        .overlay-container:hover .overlay {
            scale: 1;
        }

        .overlay-container-left:hover .overlay {
            scale: 1;
        }

        .card {
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0px 1px 4px 1px #0000008a;
            cursor: pointer;
        }

        .card-footer {
            padding: 10px 0;
        }

        /* //card css category */
        .cat-card {
            transition: all 0.3s ease;
        }

        .cat-card:hover {
            transform: translateY(-5px);
        }

        .cat-card .cat-thumnail {
            transition: transform 0.4s ease;
        }

        .cat-card:hover .cat-thumnail {
            transform: scale(1.08);
        }

        /* //card css category */

        /* border after */
        .g-img {
            position: relative;
            display: inline-block;
            padding-bottom: 20px;
        }

        .g-img::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 25px;
            background: url("{{ asset('frontend/assets') }}/images/border.jpg") no-repeat center bottom;
            background-size: contain;
        }

        /* border after */

        /* cart css  */

        .btn-plus,
        .btn-minus {
            padding: 1px !important;
        }

        .card-input {
            width: 44px;
            padding: 0px 5px !important;
            margin: 0px 5px;
            height: 24px;
        }

        .cmb-5 {
            margin-bottom: 8px !important;
        }

        /* //card hover effect */

        /* responsive */
        .mb-2 {
            margin-bottom: 8px !important;
        }

        .d-none {
            display: none;
        }

        @media screen and (min-width: 1025px) {
            .mb-0 {
                margin-bottom: 0px !important;
            }

            .d-lg-block {
                display: block !important;
            }
        }

        /* fadeup style css start  */
        /* initial hidden state */
        .fade-up-on-scroll {
            opacity: 0;
            transform: translateY(100px);
            transition: opacity 0.8s ease, transform 0.8s ease;
            will-change: opacity, transform;
        }

        /* when visible */
        .fade-up-on-scroll.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* fadeup style css end  */

        /* slick slider next and prev button  */

        .biolife-carousel .slick-arrow {
            opacity: 1 !important;
            /* always visible */
            transform: translateY(0) !important;
            /* কোনো slide up effect থাকবে না */
            visibility: visible !important;
        }

        .biolife-carousel:hover .slick-arrow {
            transform: translateY(0) !important;
            /* hover এ কোনো translate হবে না */
        }

        /* slick slider next and prev button  */

        /* top video css start */
        .video-header-wrapper {
            position: relative;
            width: 100%;
            height: 100vh;
            overflow: hidden;
        }

        /* Video */
        .video-header-wrapper .bg-video {
            position: absolute;
            top: 50%;
            left: 50%;
            min-width: 101%;
            min-height: 100%;
            width: auto;
            height: auto;
            transform: translate(-50%, -50%);
            object-fit: cover;
            z-index: 1;
        }

        /* Dark overlay (optional but recommended) */
        .video-header-wrapper .video-overlay {
            position: absolute;
            inset: 0;
            background: rgb(0 0 0 / 21%);
            z-index: 2;
        }

        /* Header content above video */
        .video-header-wrapper header {
            position: relative;
            z-index: 999;
        }

        /* Remove background from header */
        .header-area {
            background: transparent !important;
        }

        /* top video css end */
    </style>
</head>

<body class="">
    <!-- biolife-body -->
    <!-- Preloader -->
    <!-- <div id="biof-loading">
        <div class="biof-loading-center">
            <div class="biof-loading-center-absolute">
                <div class="dot dot-one"></div>
                <div class="dot dot-two"></div>
                <div class="dot dot-three"></div>
            </div>
        </div>
    </div> -->

    @include('frontend.partials.header')

    <!-- Page Contain -->
    <div class="page-contain mt-15">
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
                    <ul class="biolife-carousel quickview-for"
                        data-slick='{"arrows":false,"dots":false,"slidesMargin":30,"slidesToShow":1,"slidesToScroll":1,"fade":true,"asNavFor":".quickview-nav"}'>
                        <li>
                            <img src="{{ asset('frontend/assets') }}/images/detail1.jpg" alt=""
                                style="width: 351px; height: 306px" width="500" height="500" />
                        </li>
                        <li>
                            <img src="{{ asset('frontend/assets') }}/images/detail2.jpg" alt=""
                                style="width: 351px; height: 306px" width="500" height="500" />
                        </li>
                        <li>
                            <img src="{{ asset('frontend/assets') }}/images/detail3.jpg" alt=""
                                style="width: 351px; height: 306px" width="500" height="500" />
                        </li>
                    </ul>
                    <ul class="biolife-carousel quickview-nav"
                        data-slick='{"arrows":true,"dots":false,"centerMode":false,"focusOnSelect":true,"slidesMargin":10,"slidesToShow":3,"slidesToScroll":1,"asNavFor":".quickview-for"}'>
                        <li>
                            <img src="{{ asset('frontend/assets') }}/images/detail1.jpg" alt=""
                                style="height: 50px !important" width="88" height="88" />
                        </li>
                        <li>
                            <img src="{{ asset('frontend/assets') }}/images/detail2.jpg" alt=""
                                style="height: 50px !important" width="88" height="88" />
                        </li>
                        <li>
                            <img src="{{ asset('frontend/assets') }}/images/detail3.jpg" alt=""
                                style="height: 50px !important" width="88" height="88" />
                        </li>
                    </ul>
                </div>
                <div class="product-attribute">
                    <h4 class="title">
                        <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                    </h4>
                    <div class="rating">
                        <p class="star-rating"><span class="width-80percent"></span></p>
                    </div>

                    <div class="price price-contain">
                        <ins><span class="price-amount"><span class="currencySymbol">৳ </span>480</span></ins>
                        <del><span class="price-amount"><span class="currencySymbol">৳ </span>528</span></del>
                    </div>
                    <p class="excerpt">
                        অর্গানিক ফুডের বিশ্বস্ত প্রতিষ্ঠানপ্রথম কথা অর্গানিক ফুড নিয়ে
                        আপনাদের অনেকের মনেই দ্বিধা দ্বন্দ্ব ও সন্দেহ থাকে আর এটা থাকাই
                        স্বাভাবিক। সবাই খাটি পণ্যটি খেতে চায়।
                    </p>
                    <div class="from-cart">
                        <div class="qty-input">
                            <input type="text" name="qty12554" value="1" data-max_value="20"
                                data-min_value="1" data-step="1" />
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
                                    <li><a href="#" class="meta-link">Honey</a></li>
                                    <li><a href="#" class="meta-link">Organic Food</a></li>
                                </ul>
                            </div>
                            <div class="product-atts-item">
                                <b class="meta-title">Tags:</b>
                                <ul class="meta-list">
                                    <li><a href="#" class="meta-link">food theme</a></li>
                                    <li><a href="#" class="meta-link">organic food</a></li>
                                    <li><a href="#" class="meta-link">organic theme</a></li>
                                </ul>
                            </div>
                            <div class="product-atts-item">
                                <b class="meta-title">Brand:</b>
                                <ul class="meta-list">
                                    <li><a href="#" class="meta-link">Kamran Hoeny</a></li>
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
    <!-- <a class="btn-scroll-top"><i class="biolife-icon icon-left-arrow"></i></a> -->

    <script src="{{ asset('frontend/assets') }}/js/jquery-3.4.1.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/jquery.countdown.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/jquery.nice-select.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/jquery.nicescroll.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@6.1/dist/fancybox/fancybox.umd.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/slick.min.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/biolife.framework.js"></script>
    <script src="{{ asset('frontend/assets') }}/js/functions.js"></script>
    <script>
        $(document).ready(function() {
            $("#openOffcanvas").click(function() {
                $("#offcanvasRight").addClass("active");
                $(".offcanvas-overlay").addClass("active");
            });

            $(".close-offcanvas, .offcanvas-overlay").click(function() {
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

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const elements = document.querySelectorAll(".fade-up-on-scroll");

            const observer = new IntersectionObserver(
                (entries) => {
                    entries.forEach((entry) => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add("is-visible");
                            observer.unobserve(entry.target); // একবারই animation হবে
                        }
                    });
                }, {
                    threshold: 0.2, // 20% visible হলে trigger
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
</body>

</html>
