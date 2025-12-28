<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            @if (Auth::check())
                <div class="nav">
                    {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                    <a class="nav-link {{ Request::routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    @if (checkAccess('categories.create') ||
                            checkAccess('categories.index') ||
                            checkAccess('subcategories.create') ||
                            checkAccess('subcategories.index') ||
                            checkAccess('client.create') ||
                            checkAccess('client.index') ||
                            checkAccess('sizes_colors.index'))
                        <!-- Catalog Setup -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseCatalogSetup" aria-expanded="false"
                            aria-controls="collapseCatalogSetup">
                            <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                            Inventory
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::routeIs('categories.*') || Request::routeIs('subcategories.*') || Request::routeIs('client.*') || Request::routeIs('sizes_colors.*') ? 'show' : '' }}"
                            id="collapseCatalogSetup" aria-labelledby="headingCatalogSetup"
                            data-bs-parent="#sidenavAccordion">

                            <nav class="sb-sidenav-menu-nested nav">
                                {{-- Categories --}}
                                @if (checkAccess('categories.create'))
                                    <a class="nav-link {{ Request::routeIs('categories.create') ? 'active' : '' }}"
                                        href="{{ route('categories.create') }}">Create Category</a>
                                @endif
                                @if (checkAccess('categories.index'))
                                    <a class="nav-link {{ Request::routeIs('categories.index') ? 'active' : '' }}"
                                        href="{{ route('categories.index') }}">Category List</a>
                                @endif

                                {{-- Subcategories --}}
                                @if (checkAccess('subcategories.create'))
                                    <a class="nav-link {{ Request::routeIs('subcategories.create') ? 'active' : '' }}"
                                        href="{{ route('subcategories.create') }}">Create Subcategory</a>
                                @endif
                                @if (checkAccess('subcategories.index'))
                                    <a class="nav-link {{ Request::routeIs('subcategories.index') ? 'active' : '' }}"
                                        href="{{ route('subcategories.index') }}">Subcategory List</a>
                                @endif

                                {{-- Brands --}}
                                @if (checkAccess('client.create'))
                                    <a class="nav-link {{ Request::routeIs('client.create') ? 'active' : '' }}"
                                        href="{{ route('client.create') }}">Create Brand</a>
                                @endif
                                @if (checkAccess('client.index'))
                                    <a class="nav-link {{ Request::routeIs('client.index') ? 'active' : '' }}"
                                        href="{{ route('client.index') }}">Brand List</a>
                                @endif

                                {{-- Size & Color --}}
                                @if (checkAccess('sizes_colors.index'))
                                    <a class="nav-link {{ Request::routeIs('sizes_colors.index') ? 'active' : '' }}"
                                        href="{{ route('sizes_colors.index') }}">
                                        Create Size & Color
                                    </a>
                                @endif
                            </nav>
                        </div>
                    @endif

                    <!-- Coupons -->
                    @if (checkAccess('coupons.create') || checkAccess('coupons.index'))
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseCoupons" aria-expanded="false" aria-controls="collapseCoupons">
                            <div class="sb-nav-link-icon"><i class="fas fa-ticket-alt"></i></div>
                            Coupons
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::routeIs('coupons.*') ? 'show' : '' }}" id="collapseCoupons"
                            aria-labelledby="headingCoupons" data-bs-parent="#sidenavAccordion">

                            <nav class="sb-sidenav-menu-nested nav">
                                @if (checkAccess('coupons.create'))
                                    <a class="nav-link {{ Request::routeIs('coupons.create') ? 'active' : '' }}"
                                        href="{{ route('coupons.create') }}">Create Coupon</a>
                                @endif

                                @if (checkAccess('coupons.index'))
                                    <a class="nav-link {{ Request::routeIs('coupons.index') ? 'active' : '' }}"
                                        href="{{ route('coupons.index') }}">Coupon List</a>
                                @endif
                            </nav>
                        </div>
                    @endif

                    <!-- Web Content -->
                    @if (checkAccess('sliders.create') ||
                            checkAccess('sliders.index') ||
                            checkAccess('features.create') ||
                            checkAccess('features.index') ||
                            checkAccess('banners.create') ||
                            checkAccess('banners.index') ||
                            checkAccess('products.create') ||
                            checkAccess('products.index') ||
                            checkAccess('products.variants.index') ||
                            checkAccess('faqs.create') ||
                            checkAccess('faqs.index') ||
                            checkAccess('review.index') ||
                            checkAccess('return.index') ||
                            checkAccess('privacy.index') ||
                            checkAccess('terms.index') ||
                            checkAccess('contact-us.index'))
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseWebContentMenu"
                            aria-expanded="{{ Request::is('sliders*') || Request::is('feature*') || Request::is('banners*') || Request::is('products*') || Request::is('product-variants*') || Request::is('faq*') || Request::routeIs('about-us.index', 'return.index', 'privacy.index', 'terms.index', 'contact-us.index', 'reviews.index', 'faqs.*') ? 'true' : 'false' }}"
                            aria-controls="collapseWebContentMenu">
                            <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                            Web Content
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::is('sliders*') || Request::is('feature*') || Request::is('banners*') || Request::is('products*') || Request::is('product-variants*') || Request::is('faq*') || Request::routeIs('about-us.index', 'return.index', 'privacy.index', 'terms.index', 'contact-us.index', 'reviews.index') ? 'show' : '' }}"
                            id="collapseWebContentMenu" aria-labelledby="headingWebContentMenu"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">

                                <!-- Sliders -->
                                @if (checkAccess('sliders.create') || checkAccess('sliders.index'))
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapseSlidersMenu"
                                        aria-expanded="{{ Request::is('sliders*') ? 'true' : 'false' }}"
                                        aria-controls="collapseSlidersMenu">
                                        Sliders
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse {{ Request::is('sliders*') ? 'show' : '' }}"
                                        id="collapseSlidersMenu" aria-labelledby="headingSlidersMenu"
                                        data-bs-parent="#collapseWebContentMenu">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if (checkAccess('sliders.create'))
                                                <a class="nav-link {{ Request::routeIs('sliders.create') ? 'active' : '' }}"
                                                    href="{{ route('sliders.create') }}">Create Slider</a>
                                            @endif
                                            @if (checkAccess('sliders.index'))
                                                <a class="nav-link {{ Request::routeIs('sliders.index') ? 'active' : '' }}"
                                                    href="{{ route('sliders.index') }}">Slider Lists</a>
                                            @endif
                                        </nav>
                                    </div>
                                @endif

                                <!-- Features -->
                                @if (checkAccess('features.create') || checkAccess('features.index'))
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFeaturesMenu"
                                        aria-expanded="{{ Request::is('feature*') ? 'true' : 'false' }}"
                                        aria-controls="collapseFeaturesMenu">
                                        Features
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse {{ Request::is('feature*') ? 'show' : '' }}"
                                        id="collapseFeaturesMenu" aria-labelledby="headingFeaturesMenu"
                                        data-bs-parent="#collapseWebContentMenu">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if (checkAccess('features.create'))
                                                <a class="nav-link {{ Request::routeIs('features.create') ? 'active' : '' }}"
                                                    href="{{ route('features.create') }}">Create Features</a>
                                            @endif
                                            @if (checkAccess('features.index'))
                                                <a class="nav-link {{ Request::routeIs('features.index') ? 'active' : '' }}"
                                                    href="{{ route('features.index') }}">Features List</a>
                                            @endif
                                        </nav>
                                    </div>
                                @endif

                                <!-- Banners -->
                                @if (checkAccess('banners.create') || checkAccess('banners.index'))
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapseBannersMenu"
                                        aria-expanded="{{ Request::is('banners*') ? 'true' : 'false' }}"
                                        aria-controls="collapseBannersMenu">
                                        Banners
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse {{ Request::is('banners*') ? 'show' : '' }}"
                                        id="collapseBannersMenu" aria-labelledby="headingBannersMenu"
                                        data-bs-parent="#collapseWebContentMenu">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if (checkAccess('banners.create'))
                                                <a class="nav-link {{ Request::routeIs('banners.create') ? 'active' : '' }}"
                                                    href="{{ route('banners.create') }}">Create Banner</a>
                                            @endif
                                            @if (checkAccess('banners.index'))
                                                <a class="nav-link {{ Request::routeIs('banners.index') ? 'active' : '' }}"
                                                    href="{{ route('banners.index') }}">Banner Lists</a>
                                            @endif
                                        </nav>
                                    </div>
                                @endif

                                <!-- Products -->
                                @if (checkAccess('products.create') || checkAccess('products.index') || checkAccess('products.variants.index'))
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapseProductsMenu"
                                        aria-expanded="{{ Request::is('products*') || Request::is('product-variants*') ? 'true' : 'false' }}"
                                        aria-controls="collapseProductsMenu">
                                        Products
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse {{ Request::is('products*') || Request::is('product-variants*') ? 'show' : '' }}"
                                        id="collapseProductsMenu" aria-labelledby="headingProductsMenu"
                                        data-bs-parent="#collapseWebContentMenu">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if (checkAccess('products.create'))
                                                <a class="nav-link {{ Request::routeIs('products.create') ? 'active' : '' }}"
                                                    href="{{ route('products.create') }}">Create Product</a>
                                            @endif
                                            @if (checkAccess('products.index'))
                                                <a class="nav-link {{ Request::routeIs('products.index') ? 'active' : '' }}"
                                                    href="{{ route('products.index') }}">Product Lists</a>
                                            @endif
                                            @if (checkAccess('products.variants.index'))
                                                <a class="nav-link {{ Request::routeIs('products.variants.index') ? 'active' : '' }}"
                                                    href="{{ route('products.variants.index') }}">Variant Manage</a>
                                            @endif
                                        </nav>
                                    </div>
                                @endif

                                <!-- FAQs -->
                                @if (checkAccess('faqs.create') || checkAccess('faqs.index'))
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapseFaqsMenu"
                                        aria-expanded="{{ Request::is('faq*') ? 'true' : 'false' }}"
                                        aria-controls="collapseFaqsMenu">
                                        FAQs
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse {{ Request::is('faq*') ? 'show' : '' }}"
                                        id="collapseFaqsMenu" aria-labelledby="headingFaqsMenu"
                                        data-bs-parent="#collapseWebContentMenu">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if (checkAccess('faqs.create'))
                                                <a class="nav-link {{ Request::routeIs('faqs.create') ? 'active' : '' }}"
                                                    href="{{ route('faqs.create') }}">Create FAQ</a>
                                            @endif
                                            @if (checkAccess('faqs.index'))
                                                <a class="nav-link {{ Request::routeIs('faqs.index') ? 'active' : '' }}"
                                                    href="{{ route('faqs.index') }}">FAQ Lists</a>
                                            @endif
                                        </nav>
                                    </div>
                                @endif

                                <!-- Reviews -->
                                @if (checkAccess('review.index'))
                                    <a class="nav-link {{ Request::routeIs('reviews.index') ? 'active' : '' }}"
                                        href="{{ route('reviews.index') }}">Reviews</a>
                                @endif

                                <!-- Return Policy -->
                                @if (checkAccess('return.index'))
                                    <a class="nav-link {{ Request::routeIs('return.index') ? 'active' : '' }}"
                                        href="{{ route('return.index') }}">Return Policy</a>
                                @endif

                                <!-- Privacy Policy -->
                                @if (checkAccess('privacy.index'))
                                    <a class="nav-link {{ Request::routeIs('privacy.index') ? 'active' : '' }}"
                                        href="{{ route('privacy.index') }}">Privacy Policy</a>
                                @endif

                                <!-- Terms & Conditions -->
                                @if (checkAccess('terms.index'))
                                    <a class="nav-link {{ Request::routeIs('terms.index') ? 'active' : '' }}"
                                        href="{{ route('terms.index') }}">Terms & Conditions</a>
                                @endif

                                <!-- Contact Us -->
                                @if (checkAccess('contact-us.index'))
                                    <a class="nav-link {{ Request::routeIs('contact-us.index') ? 'active' : '' }}"
                                        href="{{ route('contact-us.index') }}">Contact Messages</a>
                                @endif
                            </nav>
                        </div>
                    @endif

                    <!-- Manage Order -->
                    @if (checkAccess('orders.index') ||
                            checkAccess('orders.pending') ||
                            checkAccess('orders.approved') ||
                            checkAccess('orders.declined') ||
                            checkAccess('orders.completed'))
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseOrders"
                            aria-expanded="{{ Request::is('orders*') ? 'true' : 'false' }}"
                            aria-controls="collapseOrders">
                            <div class="sb-nav-link-icon"><i class="fas fa-box"></i></div>
                            Manage Order
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::is('orders*') ? 'show' : '' }}" id="collapseOrders"
                            aria-labelledby="headingOrders" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                @if (checkAccess('orders.index'))
                                    <a class="nav-link {{ Request::routeIs('orders.index') && !request('status') ? 'active' : '' }}"
                                        href="{{ route('orders.index') }}">
                                        All Orders
                                    </a>
                                @endif

                                @if (checkAccess('orders.pending'))
                                    <a class="nav-link {{ request('status') == 'p' ? 'active' : '' }}"
                                        href="{{ route('orders.index', ['status' => 'p']) }}">
                                        Pending Orders
                                    </a>
                                @endif

                                @if (checkAccess('orders.approved'))
                                    <a class="nav-link {{ request('status') == 'a' ? 'active' : '' }}"
                                        href="{{ route('orders.index', ['status' => 'a']) }}">
                                        Approved Orders
                                    </a>
                                @endif

                                @if (checkAccess('orders.declined'))
                                    <a class="nav-link {{ request('status') == 'd' ? 'active' : '' }}"
                                        href="{{ route('orders.index', ['status' => 'd']) }}">
                                        Declined Orders
                                    </a>
                                @endif

                                @if (checkAccess('orders.completed'))
                                    <a class="nav-link {{ request('status') == 'c' ? 'active' : '' }}"
                                        href="{{ route('orders.index', ['status' => 'c']) }}">
                                        Completed Orders
                                    </a>
                                @endif
                            </nav>
                        </div>
                    @endif

                    <!-- Users -->
                    @if (checkAccess('users.create') || checkAccess('users.index'))
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseLayouts"
                            aria-expanded="{{ Request::is('users*') ? 'true' : 'false' }}"
                            aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                            Users
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::is('users*') ? 'show' : '' }}" id="collapseLayouts"
                            aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                @if (checkAccess('users.create'))
                                    <a class="nav-link {{ Request::routeIs('users.create') ? 'active' : '' }}"
                                        href="{{ route('users.create') }}">Create User</a>
                                @endif

                                @if (checkAccess('users.index'))
                                    <a class="nav-link {{ Request::routeIs('users.index') ? 'active' : '' }}"
                                        href="{{ route('users.index') }}">User List</a>
                                @endif
                            </nav>
                        </div>
                    @endif

                    <!-- Settings -->
                    @if (checkAccess('setting'))
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseWebContent"
                            aria-expanded="{{ Request::routeIs('setting') ? 'true' : 'false' }}"
                            aria-controls="collapseWebContent">
                            <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                            Settings
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::routeIs('setting') ? 'show' : '' }}" id="collapseWebContent"
                            aria-labelledby="headingWebContent" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link {{ Request::routeIs('setting') ? 'active' : '' }}"
                                    href="{{ route('setting') }}">Company Settings</a>
                            </nav>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </nav>
</div>
