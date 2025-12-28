@extends('frontend.layouts.master')

@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <nav class="biolife-nav nav-86px">
            <ul>
                <li class="nav-item">
                    <a href="{{route('home')}}" class="permal-link">Home</a>
                </li>
                <li class="nav-item">
                    <span class="current-page">About</span>
                </li>
            </ul>
        </nav>
    </div>

    <div class="container">
        <div class="mt-30 mb-30">
            <div class="g-img text-center" style="width: 100%;">
                <h3 class="title text-center cmb-5">Welcome to Kamran Honey!</h3>
            </div>

        </div>

        <div class="container">
            <div class="row mb-30  align-items-center">
                <div class="col-md-6 col-12">
                    <img src="{{ asset('frontend/assets') }}/images/huney2.gif" class="img-fluid" alt="">
                </div>
                <div class="col-md-6 col-12">
                    <div class="text-wraper">
                        <p>We are dedicated to bringing you 100% pure and natural honey, carefully sourced from
                            trusted beekeepers and untouched by artificial processing. Our honey is collected
                            with respect for nature, ensuring its original taste, aroma, and nutritional value
                            remain intact.
                        </p>
                        <p>Quality, purity, and customer satisfaction are at the heart of everything we do. From
                            hive to home, we strive to deliver the finest honey you can trust and enjoy every
                            day.

                        </p>
                    </div>
                </div>


            </div>
        </div>
    </div>

    <div class="why-choose-us-block">
        <div class="container ">
            <div class="mb-30">
                <div class="g-img text-center" style="width: 100%;">
                    <h4 class="title text-center cmb-5">Why Choose Us</h4>
                </div>

            </div>


            <div class="showcase">
                <div class="sc-child sc-left-position">
                    <ul class="sc-list">
                        <li>
                            <div class="sc-element color-01">
                                <span class="biolife-icon icon-fresh-drink"></span>
                                <div class="txt-content">
                                    <span class="number">01</span>
                                    <b class="title">100% Pure Honey</b>
                                    <p class="desc">
                                        Our honey is completely natural, free from sugar syrup, additives, or
                                        preservatives.
                                    </p>
                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="sc-element color-02">
                                <span class="biolife-icon icon-healthy-about"></span>
                                <div class="txt-content">
                                    <span class="number">02</span>
                                    <b class="title">Rich in Nutrients</b>
                                    <p class="desc">
                                        Packed with natural enzymes, vitamins, and antioxidants that support daily
                                        health.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="sc-child sc-center-position">
                    <figure>
                        <img src="{{ asset('frontend/assets') }}/images/about2.jpg" alt="Pure Natural Honey" width="622" height="656">
                    </figure>
                </div>

                <div class="sc-child sc-right-position">
                    <ul class="sc-list">
                        <li>
                            <div class="sc-element color-05">
                                <span class="biolife-icon icon-arteries-about"></span>
                                <div class="txt-content">
                                    <span class="number">03</span>
                                    <b class="title">Supports Heart Health</b>

                                </div>
                            </div>
                        </li>

                        <li>
                            <div class="sc-element color-06">
                                <span class="biolife-icon icon-title"></span>
                                <div class="txt-content">
                                    <span class="number">04</span>
                                    <b class="title">Quality Assured</b>
                                    <p class="desc">
                                        Every batch is carefully tested to ensure purity, taste, and premium
                                        quality.
                                    </p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
@endsection
