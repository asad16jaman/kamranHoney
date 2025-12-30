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
                            checkAccess('client.index')||
                            checkAccess('unit.index') ||
                            checkAccess('unit.create'))
                        <!-- Catalog Setup -->
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseCatalogSetup" aria-expanded="false"
                            aria-controls="collapseCatalogSetup">
                            <div class="sb-nav-link-icon"><i class="fas fa-warehouse"></i></div>
                            Inventory
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{ Request::routeIs('categories.*') || Request::routeIs('subcategories.*') || Request::routeIs('client.*') || Request::routeIs('unit.*') ? 'show' : '' }}"
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

                                {{-- Units --}}
                                @if (checkAccess('unit.create'))
                                    <a class="nav-link {{ Request::routeIs('unit.create') ? 'active' : '' }}"
                                        href="{{ route('unit.create') }}">Create Unit</a>
                                @endif
                                @if (checkAccess('unit.index'))
                                    <a class="nav-link {{ Request::routeIs('unit.index') ? 'active' : '' }}"
                                        href="{{ route('unit.index') }}">Unit List</a>
                                @endif
                            </nav>
                        </div>
                    @endif

                    <!-- Web Content -->
                    @if (checkAccess('products.create') ||
                            checkAccess('products.index') ||
                            checkAccess('blogs.create') ||
                            checkAccess('blogs.index') ||
                            checkAccess('review.create') ||
                            checkAccess('review.index') ||
                            checkAccess('privacy.index') ||
                            checkAccess('contact-us.index'))
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                            data-bs-target="#collapseWebContentMenu"
                            aria-expanded="{{ Request::is('products*') || Request::is('blogs*') || Request::is('review*') || Request::routeIs('privacy.index', 'contact-us.index') ? 'true' : 'false' }}"
                            aria-controls="collapseWebContentMenu">
                            <div class="sb-nav-link-icon"><i class="fas fa-globe"></i></div>
                            Web Content
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse {{  Request::is('products*') || Request::is('blogs*') || Request::is('review*') || Request::routeIs('privacy.index', 'contact-us.index') ? 'show' : '' }}"
                            id="collapseWebContentMenu" aria-labelledby="headingWebContentMenu"
                            data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
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
                                        </nav>
                                    </div>
                                @endif

                                <!-- Blog -->
                                @if (checkAccess('blogs.create') || checkAccess('blogs.index'))
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapseBlogMenu"
                                        aria-expanded="{{ Request::is('blogs*') ? 'true' : 'false' }}"
                                        aria-controls="collapseBlogMenu">
                                        Blog
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse {{ Request::is('blogs*') ? 'show' : '' }}"
                                        id="collapseBlogMenu" aria-labelledby="headingBlogMenu"
                                        data-bs-parent="#collapseWebContentMenu">
                                        <nav class="sb-sidenav-menu-nested nav">
                                            @if (checkAccess('blogs.create'))
                                                <a class="nav-link {{ Request::routeIs('blogs.create') ? 'active' : '' }}"
                                                    href="{{ route('blogs.create') }}">Create Blog</a>
                                            @endif
                                            @if (checkAccess('blogs.index'))
                                                <a class="nav-link {{ Request::routeIs('blogs.index') ? 'active' : '' }}"
                                                    href="{{ route('blogs.index') }}">Blog List</a>
                                            @endif
                                        </nav>
                                    </div>
                                @endif

                                <!-- Review -->
                                @if (checkAccess('review.create') || checkAccess('review.index'))
                                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse"
                                        data-bs-target="#collapseReviewMenu"
                                        aria-expanded="{{ Request::is('review*') ? 'true' : 'false' }}"
                                        aria-controls="collapseReviewMenu">
                                        Review
                                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                                    </a>
                                    <div class="collapse {{ Request::is('review*') ? 'show' : '' }}"
                                        id="collapseReviewMenu" aria-labelledby="headingReviewMenu"
                                        data-bs-parent="#collapseWebContentMenu">
                                        <nav class="sb-sidenav-menu-nested nav">

                                            @if (checkAccess('review.create'))
                                                <a class="nav-link {{ Request::routeIs('review.create') ? 'active' : '' }}"
                                                    href="{{ route('review.create') }}">Create Review</a>
                                            @endif

                                            @if (checkAccess('review.index'))
                                                <a class="nav-link {{ Request::routeIs('review.index') ? 'active' : '' }}"
                                                    href="{{ route('review.index') }}">Review List</a>
                                            @endif
                                        </nav>
                                    </div>
                                @endif

                                <!-- Privacy Policy -->
                                @if (checkAccess('privacy.index'))
                                    <a class="nav-link {{ Request::routeIs('privacy.index') ? 'active' : '' }}"
                                        href="{{ route('privacy.index') }}">Privacy Policy</a>
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
