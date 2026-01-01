@php
    $setting = \App\Helpers\SettingsHelper::getSetting();
    $videoSrc = $setting->video_file ? asset($setting->video_file) : asset('frontend/assets/images/4293-178324579.mp4');
    $slogan = $setting->company_slogan ?? 'Your Company Slogan Here';
@endphp

@if (Route::currentRouteName() === 'home')
    <div class="video-header-wrapper">
        <!-- Background Video -->
        <video class="bg-video" autoplay muted loop playsinline>
            <source src="{{ $videoSrc }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <div class="video-overlay"></div>

        <!-- Slogan -->
        <div class="slogan-wrapper"
            style="position: absolute; left: 50px; top: 50%; transform: translateY(-50%);
                color: #fff; max-width: 600px; z-index: 10; text-shadow: 2px 2px 8px rgba(0,0,0,0.5);
                opacity: 0; animation: fadeInUp 1.5s forwards;">

            <h1 class="video-slogan" style="font-size: 6.5rem; font-weight: 900; line-height: 1.2; color: #fff;">
                {{ $slogan }}
            </h1>
        </div>
@endif

<!-- HEADER -->
<header id="header" class="header-area style-01 layout-03">
    <div class="header-top bg-main hidden-xs">
        <div class="container">
            <div class="top-bar left">
                <ul class="horizontal-menu">
                    <li>
                        <a href="tel:{{ $setting->company_phone }}"><i class="fa fa-phone"
                                aria-hidden="true"></i>{{ $setting->company_phone }}</a>
                    </li>
                    <li>
                        <a href="mailto:{{ $setting->company_email }}"><i class="fa fa-envelope"
                                aria-hidden="true"></i>{{ $setting->company_email }}</a>
                    </li>
                </ul>
            </div>
            <div class="top-bar right">
                <ul class="social-list">
                    <li>
                        <a href="{{ $setting->facebook_url }}">
                            <i class="fa fa-facebook" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <i class="fa fa-youtube" aria-hidden="true"></i>
                        </a>
                    </li>
                    <li>
                        <a href="{{ $setting->instagram_url }}">
                            <i class="fa fa-instagram" aria-hidden="true"></i>
                        </a>
                    </li>
                </ul>

                <ul class="horizontal-menu">
                    <li>
                        <a href="#" class="login-link">Track Your Order</a>
                    </li>

                    <li class="hidden-sm hidden-xs">
                        <div class="minicart-block" id="desktop-cart">
                            <div class="minicart-contain">
                                <a href="javascript:void(0)" id="openOffcanvasDesktop" class="cart-icon">
                                    <i class="icon-cart-mini biolife-icon"></i>

                                    <span class="cart-badge" id="desktop-cart-qty">
                                        {{ array_sum(array_column(session('cart', []), 'qty')) }}
                                    </span>
                                </a>
                            </div>
                        </div>
                    </li>

                    <li class="hidden-sm hidden-xs user-dropdown">
                        <a href="javascript:void(0)" class="link-to user-toggle">
                            <i class="biolife-icon icon-login"></i>
                        </a>

                        <div class="user-menu">
                            <div class="user-info">
                                <img src="https://i.pravatar.cc/80" alt="User">
                                <h6>Guest User</h6>
                            </div>
                            <a href="#" class="dropdown-link">
                                <i class="fa fa-sign-in"></i> Sign In
                            </a>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>

    <div class="header-middle biolife-sticky-object">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-1 col-md-6 col-xs-6">
                    <a href="{{ route('home') }}" class="biolife-logo">
                        <img style="width:100%"
                            src="{{ $setting && $setting->company_logo
                                ? asset('uploads/logo_and_icon/' . $setting->company_logo)
                                : asset('frontend/assets/images/logo-removebg-preview.png') }}"
                            alt="Company Logo" />
                    </a>
                </div>

                <span class="company-name">
                    <a href="{{ route('home') }}" style="color: black;">
                        {{ $setting->company_name ?? 'Company Name' }}
                    </a>
                </span>

                <div class="col-lg-5 col-md-7 hidden-sm hidden-xs">
                    <div class="primary-menu pull-right menu-shift-right">
                        <ul class="menu biolife-menu clone-main-menu clone-primary-menu" id="primary-menu"
                            data-menuname="main menu">
                            <li class="menu-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="menu-item"><a href="{{ route('about.view') }}">About</a></li>
                            <li class="menu-item"><a href="{{ route('all.products') }}">All Products</a></li>
                            <li class="menu-item"><a href="{{ route('contact.create') }}">Contact</a></li>

                            {{-- <li class="menu-item menu-item-has-children has-child">
                                <a href="#" class="menu-name" data-title="Pages">Pages</a>
                                <ul class="sub-menu">
                                    <li class="menu-item"><a href="#">Our Services</a></li>
                                    <li class="menu-item"><a href="#">Video Gallery</a></li>
                                    <li class="menu-item"><a href="#">Photo Gallery</a></li>
                                </ul>
                            </li> --}}
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-md-5 col-xs-6">
                    <div class="biolife-cart-info d-flex align-items-center justify-content-end">

                        <div class="header-search-bar layout-01 d-none d-lg-block me-3 sm hidden-sm hidden-xs">
                            <form action="#" class="form-search" method="get">
                                <input type="text" name="s" class="input-text" placeholder="Search here..." />
                                <button type="submit" class="btn-submit">
                                    <i class="biolife-icon icon-search"></i>
                                </button>
                            </form>
                        </div>

                        <div class="mobile-cart hidden-md hidden-lg me-2">
                            <div class="minicart-block" id="mobile-cart">
                                <div class="minicart-contain">
                                    <a href="javascript:void(0)" id="openOffcanvasDesktop" class="cart-icon">
                                        <i class="icon-cart-mini biolife-icon"></i>

                                        <span class="cart-badge" id="desktop-cart-qty">
                                            {{ array_sum(array_column(session('cart', []), 'qty')) }}
                                        </span>
                                    </a>
                                </div>
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.querySelector('.user-toggle');
        const menu = document.querySelector('.user-menu');

        toggle.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });

        document.addEventListener('click', function() {
            menu.style.display = 'none';
        });
    });
</script>
