@if (Route::currentRouteName() === 'home')
    <div class="video-header-wrapper">
        <!-- Background Video -->
        <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ asset('frontend/assets/images/4293-178324579.mp4') }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="video-overlay"></div>
@endif

<!-- HEADER -->
<header id="header" class="header-area style-01 layout-03">
    <div class="header-top bg-main hidden-xs">
        <div class="container">
            <div class="top-bar left">
                <ul class="horizontal-menu">
                    <li>
                        <a href="#"><i class="fa fa-phone" aria-hidden="true"></i>+8801711275469</a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-envelope" aria-hidden="true"></i>cmd@jjnhoney.com</a>
                    </li>
                </ul>
            </div>
            <div class="top-bar right">
                <ul class="social-list">
                    <li>
                        <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                    </li>
                </ul>
                <ul class="horizontal-menu">
                    <li><a href="#" class="login-link">Track Your Order</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="header-middle biolife-sticky-object">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-1 col-md-6 col-xs-6">
                    <a href="{{ route('home') }}" class="biolife-logo">
                        <img style="width:100%" src="{{ asset('frontend/assets/images/logo-removebg-preview.png') }}"
                            alt="biolife logo" />
                    </a>
                </div>

                <div class="col-lg-5 col-md-7 hidden-sm hidden-xs">
                    <div class="primary-menu">
                        <ul class="menu biolife-menu clone-main-menu clone-primary-menu" id="primary-menu"
                            data-menuname="main menu">
                            <li class="menu-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="menu-item"><a href="{{ route('about.view') }}">About</a></li>
                            <li class="menu-item"><a href="{{ route('all.products') }}">All Products</a></li>
                            <li class="menu-item"><a href="{{ route('contact.create') }}">Contact</a></li>

                            <li class="menu-item menu-item-has-children has-child">
                                <a href="#" class="menu-name" data-title="Pages">Pages</a>
                                <ul class="sub-menu">
                                    <li class="menu-item"><a href="#">Our Services</a></li>
                                    <li class="menu-item"><a href="#">Video Gallery</a></li>
                                    <li class="menu-item"><a href="#">Photo Gallery</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-3 d-none d-lg-block">
                    <div class="header-search-bar layout-01">
                        <form action="#" class="form-search" method="get">
                            <input type="text" name="s" class="input-text" placeholder="Search here..." />
                            <button type="submit" class="btn-submit">
                                <i class="biolife-icon icon-search"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 col-xs-6">
                    <div class="biolife-cart-info">
                        <div class="wishlist-block hidden-sm hidden-xs">
                            <a href="#" class="link-to">
                                <span class="icon-qty-combine">
                                    <i class="biolife-icon icon-login"></i>
                                </span>
                            </a>
                        </div>

                        <div class="minicart-block">
                            <div class="minicart-contain">
                                <a href="javascript:void(0)" id="openOffcanvas" class="link-to">
                                    <span class="icon-qty-combine">
                                        <i class="icon-cart-mini biolife-icon"></i>
                                        <span class="qty">1</span>
                                    </span>
                                    <span class="sub-total ms-2">150 ৳</span>
                                </a>
                            </div>
                        </div>

                        <div class="mobile-menu-toggle">
                            <a class="btn-toggle" data-object="open-mobile-menu" href="javascript:void(0)">
                                <span></span><span></span><span></span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

@if (Route::currentRouteName() === 'home')
    </div>
@endif
