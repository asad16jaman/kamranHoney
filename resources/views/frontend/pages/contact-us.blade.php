@extends('frontend.layouts.master')

<style>
    .main-title {
        font-size: 32px;
        font-weight: 700;
        color: #e17f26;
        display: block;
        margin: 0;
        line-height: 1;
        text-transform: uppercase;
    }

    /* //navbar css */
    .align-items-center {
        display: flex;
        align-items: center;
    }

    /* css for card*/
    .card-header {
        padding: 10px 15px;
        border-bottom: 1px solid #ddd;
        background-color: #f5f5f5;
        font-weight: 600;
    }

    .card-body {
        padding: 15px;
    }

    .card {
        background-color: #fff;
        border-radius: 4px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgb(0 0 0 / 52%);
        border-top: 2px solid #e17f26;
    }

    /* css for card*/

    .mb-60 {
        margin-bottom: 60px;
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

    .mb-4 {
        margin-bottom: 30px;
    }

    .d-none {
        display: none;
    }

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
        background: url('{{ asset('frontend/assets') }}/images/border.jpg') no-repeat center bottom;
        background-size: contain;
    }

    .cmb-5 {
        margin-bottom: 8px;
    }

    /* border after */

    @media screen and (min-width: 992px) {
        .d-lg-none {
            display: none;
        }

        .d-lg-block {
            display: block;
        }
    }
</style>

@section('content')
    <!--Hero Section-->
    <div class="hero-section hero-background">
        <nav class="biolife-nav nav-86px">
            <ul>
                <li class="nav-item">
                    <a href="{{ route('home') }}" class="permal-link">Home</a>
                </li>
                <li class="nav-item">
                    <span class="current-page">Contact Us</span>
                </li>
            </ul>
        </nav>
    </div>

    <div class="page-contain contact-us">
        <!-- Main content -->
        <div class="container">
            <div class="row">
                <div class="w-100 text-center mb-30 mt-30">
                    <div class="g-img">
                        <h2 class="main-title cmb-5">Our Contact</h2>
                    </div>
                </div>
                <!--Contact form-->
                <div class="col-lg-8 col-md-6 col-sm-6 col-xs-12 mb-30">

                    <div class="contact-form-container">
                        <div class="card">
                            <div class="card-body">
                                <form action="#" name="frm-contact">
                                    <p class="form-row">
                                        <input type="text" name="name" value="" placeholder="Your Name"
                                            class="txt-input" />
                                    </p>
                                    <p class="form-row">
                                        <input type="email" name="email" value="" placeholder="Email Address"
                                            class="txt-input" />
                                    </p>
                                    <p class="form-row">
                                        <input type="tel" name="phone" value="" placeholder="Phone Number"
                                            class="txt-input" />
                                    </p>
                                    <p class="form-row">
                                        <textarea name="mes" id="mes-1" cols="30" rows="9" placeholder="Leave Message"></textarea>
                                    </p>
                                    <p class="form-row">
                                        <button class="btn btn-submit" type="submit">
                                            send message
                                        </button>
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
                <!--Contact info-->
                <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <div class="contact-info-container">

                        <p class="frst-desc">
                            We are committed to delivering 100% pure and natural honey sourced with care. For
                            product inquiries, orders, or support, please contact us — we’re always happy to
                            help.
                        </p>

                        <div class="card">
                            <div class="card-body">
                                <ul class="addr-info">
                                    <li>
                                        <div class="if-item">
                                            <b class="tie">Addess:</b>
                                            <p class="dsc">
                                                7563 St. Vicent Place, Glasgow, Greater<br />Newyork
                                                NH7689, UK
                                            </p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="if-item">
                                            <b class="tie">Phone:</b>
                                            <p class="dsc">+8801711275469</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="if-item">
                                            <b class="tie">Email:</b>
                                            <p class="dsc">cmd@jjnhoney.com</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="if-item">
                                            <b class="tie">Store Open:</b>
                                            <p class="dsc">8am - 08pm, Mon - Sat</p>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>


                    </div>
                </div>


            </div>
        </div>

        <div class="container mb-30">
            <div id="main-content" class="main-content">
                <div class="wrap-map biolife-wrap-map" id="map-block">
                    <iframe width="1920" height="591"
                        src="https://maps.google.com/maps?width=100%&amp;height=263&amp;hl=en&amp;q=1%20Grafton%20Street%2C%20Dublin%2C%20Ireland+(My%20Business%20Name)&amp;ie=UTF8&amp;t=p&amp;z=15&amp;iwloc=B&amp;output=embed"
                        frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
@endsection
