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
                                <h4 class="wgt-title">All Category</h4>
                                <div class="wgt-content">
                                    <ul class="cat-list">
                                        <li class="cat-list-item"><a href="#" class="cat-link">Organic Food</a></li>
                                        <li class="cat-list-item"><a href="#" class="cat-link">Fresh Fruit</a></li>
                                        <li class="cat-list-item"><a href="#" class="cat-link">Dried Fruits</a></li>
                                    </ul>
                                </div>
                            </div>

                            <div class="widget biolife-filter">
                                <h4 class="wgt-title">Product Tags</h4>
                                <div class="wgt-content">
                                    <ul class="tag-cloud">
                                        <li class="tag-item"><a href="#" class="tag-link">Fresh Fruit</a></li>
                                        <li class="tag-item"><a href="#" class="tag-link">Natural Food</a></li>
                                        <li class="tag-item"><a href="#" class="tag-link">Hot</a></li>
                                        <li class="tag-item"><a href="#" class="tag-link">Organics</a></li>
                                        <li class="tag-item"><a href="#" class="tag-link">Dried Organic</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </aside>
                    <!-- Main content -->
                    <div id="main-content" class="main-content col-lg-9 col-md-8 col-sm-12 col-xs-12">
                        <div class="product-category grid-style">
                            <div class="row">
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="/productsDetail.html" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="product-item">
                                        <div class="contain-product layout-default">
                                            <div class="product-thumb">
                                                <a href="#" class="link-to-product">
                                                    <img src="{{ asset('frontend/assets') }}/images/svImg.jpg" alt="Vegetables" width="270"
                                                        height="270" class="product-thumnail">
                                                </a>
                                                <p class="offer">-30%</p>
                                                <p class="attribute">HOT</p>

                                                <a class="lookup btn_call_quickview" href="#" title="Quick View"><i
                                                        class="biolife-icon icon-search"></i></a>
                                            </div>
                                            <div class="info">
                                                <h4 class="product-title">
                                                    <a href="#" class="pr-name">খলিশা ফুলের মধু</a>
                                                </h4>
                                                <div class="price ">
                                                    <ins><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>85.00</span></ins>
                                                    <del><span class="price-amount"><span class="currencySymbol">৳
                                                            </span>95.00</span></del>
                                                </div>

                                                <div class="buttons card-padding">

                                                    <a href="#" class="btn add-cart-btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        add to cart
                                                    </a>

                                                    <a href="#" class="btn add-cart-btn buy_now_btn">
                                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                                        By Now
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="biolife-panigations-block">
                                <ul class="panigation-contain">
                                    <li><span class="current-page">1</span></li>
                                    <li><a href="#" class="link-page">2</a></li>
                                    <li><a href="#" class="link-page">3</a></li>
                                    <li><span class="sep">....</span></li>
                                    <li><a href="#" class="link-page">20</a></li>
                                    <li><a href="#" class="link-page next"><i class="fa fa-angle-right"
                                                aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
