<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Responsive HTML Admin Dashboard Template based on Bootstrap 5">
    <meta name="author" content="NobleUI">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="nobleui, bootstrap, bootstrap 5, bootstrap5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <title>@yield("KEYTITLE")</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <!-- End fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <!-- core:css -->

    <link rel="stylesheet" href="<?= asset('backend/assets/vendors/core/core.css') ?>">
    <link rel="stylesheet" href="<?= asset('backend/assets/vendors/flatpickr/flatpickr.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('backend/assets/fonts/feather-font/css/iconfont.css') ?>">
    <link rel="stylesheet" href="<?= asset('backend/assets/vendors/flag-icon-css/css/flag-icon.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('backend/assets/css/demo2/style.css') ?>">
    <!-- End layout styles -->

    <style>
        /* ── Toast overrides ── */
        .toast-success { background-color: #28a745 !important; color: white !important; }
        .toast-error   { background-color: #dc3545 !important; color: white !important; }
        .toast-info    { background-color: #ffc107 !important; color: white !important; }
        .toast-warning { background-color: #ffc107 !important; color: black  !important; }
        .toast-title   { font-weight: bold; }
        .toast-message { font-size: 14px; }

        /* ── Sidebar: force inactive links to theme grey, never browser-blue ── */
        .sidebar .sidebar-body .nav .nav-item .nav-link,
        .sidebar .sidebar-body .nav .nav-item .nav-link .link-icon,
        .sidebar .sidebar-body .nav .nav-item .nav-link .link-title,
        .sidebar .sidebar-body .nav .nav-item .nav-link .link-arrow {
            color: #7987a1 !important;
        }
        .sidebar .sidebar-body .nav .nav-item.active > .nav-link,
        .sidebar .sidebar-body .nav .nav-item.active > .nav-link .link-icon,
        .sidebar .sidebar-body .nav .nav-item.active > .nav-link .link-title,
        .sidebar .sidebar-body .nav .nav-item.active > .nav-link .link-arrow {
            color: #6571ff !important;
        }
        .sidebar .sidebar-body .nav .nav-item:hover > .nav-link,
        .sidebar .sidebar-body .nav .nav-item:hover > .nav-link .link-icon,
        .sidebar .sidebar-body .nav .nav-item:hover > .nav-link .link-title,
        .sidebar .sidebar-body .nav .nav-item:hover > .nav-link .link-arrow {
            color: #6571ff !important;
        }
        /* Expanded collapse trigger */
        .sidebar .sidebar-body .nav .nav-item .nav-link[aria-expanded="true"] {
            color: #6571ff !important;
        }
        /* Sub-menu active link */
        .sidebar .sidebar-body .nav.sub-menu .nav-item .nav-link.active {
            color: #6571ff !important;
        }
        .sidebar .sidebar-body .nav.sub-menu .nav-item .nav-link {
            color: #7987a1 !important;
        }

        /* ── Responsiveness ── */
        /* Navbar: hide date/time/email labels on very small screens */
        @media (max-width: 575px) {
            .navbar .navbar-content .navbar-nav .nav-item:not(:last-child) {
                display: none;
            }
            .navbar .search-form {
                max-width: 140px;
            }
            .page-content {
                padding: 1rem 0.75rem;
            }
        }
        /* Tables always scrollable horizontally */
        .page-content .table-responsive,
        .page-content table {
            width: 100%;
        }
        .page-content .card-body {
            overflow-x: auto;
        }
        /* Prevent content overflow */
        .page-wrapper {
            min-width: 0;
            overflow-x: hidden;
        }
        /* Form controls on small screens */
        @media (max-width: 767px) {
            .card-body .row > [class*="col-md"] {
                margin-bottom: 0.5rem;
            }
            .d-flex.justify-content-between {
                flex-wrap: wrap;
                gap: 0.5rem;
            }
            .navbar .navbar-content {
                flex-wrap: nowrap;
                overflow: hidden;
            }
            /* Stack action buttons vertically on mobile */
            td .d-flex {
                flex-wrap: wrap;
                gap: 2px;
            }
        }
    </style>
</head>
<body>
    <div class="main-wrapper">

        <!-- Sidebar -->
        <nav class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                    Admin<span>Dashboard</span>
                </a>
                <div class="sidebar-toggler not-active">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
            <div class="sidebar-body">
                <ul class="nav">

                    {{-- ── Main ── --}}
                    <li class="nav-item nav-category">Main</li>
                    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>

                    {{-- ── Orders ── --}}
                    @php $ordersActive = request()->routeIs('index.order', 'order.*'); @endphp
                    <li class="nav-item nav-category">Orders</li>
                    <li class="nav-item {{ $ordersActive ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#orderCollapse" role="button"
                           aria-expanded="{{ $ordersActive ? 'true' : 'false' }}" aria-controls="orderCollapse">
                            <i class="link-icon" data-feather="shopping-cart"></i>
                            <span class="link-title">Order Management</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $ordersActive ? 'show' : '' }}" id="orderCollapse">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}" class="nav-link {{ request()->routeIs('index.order') && !request()->has('status') ? 'active' : '' }}">All Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=pending" class="nav-link {{ request()->routeIs('index.order') && request()->status === 'pending' ? 'active' : '' }}">Pending Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=processing" class="nav-link {{ request()->routeIs('index.order') && request()->status === 'processing' ? 'active' : '' }}">Processing Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=shipped" class="nav-link {{ request()->routeIs('index.order') && request()->status === 'shipped' ? 'active' : '' }}">Shipped Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=completed" class="nav-link {{ request()->routeIs('index.order') && request()->status === 'completed' ? 'active' : '' }}">Completed Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=cancelled" class="nav-link {{ request()->routeIs('index.order') && request()->status === 'cancelled' ? 'active' : '' }}">Cancelled Orders</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- ── Product Data ── --}}
                    @php
                        $sizeActive  = request()->routeIs('size.*');
                        $brandActive = request()->routeIs('brand.*');
                    @endphp
                    <li class="nav-item nav-category">Product Data</li>
                    <li class="nav-item {{ $sizeActive ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sizeCollapse" role="button"
                           aria-expanded="{{ $sizeActive ? 'true' : 'false' }}" aria-controls="sizeCollapse">
                            <i class="link-icon" data-feather="maximize-2"></i>
                            <span class="link-title">Size</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $sizeActive ? 'show' : '' }}" id="sizeCollapse">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('size.create') }}" class="nav-link {{ request()->routeIs('size.create') ? 'active' : '' }}">Add Size</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('size.index') }}" class="nav-link {{ request()->routeIs('size.index') ? 'active' : '' }}">Show Sizes</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item {{ $brandActive ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#brandCollapse" role="button"
                           aria-expanded="{{ $brandActive ? 'true' : 'false' }}" aria-controls="brandCollapse">
                            <i class="link-icon" data-feather="tag"></i>
                            <span class="link-title">Brand</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $brandActive ? 'show' : '' }}" id="brandCollapse">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('brand.create') }}" class="nav-link {{ request()->routeIs('brand.create') ? 'active' : '' }}">Add Brand</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('brand.index') }}" class="nav-link {{ request()->routeIs('brand.index') ? 'active' : '' }}">Show Brands</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- ── Products ── --}}
                    @php $productActive = request()->routeIs('product.*'); @endphp
                    <li class="nav-item nav-category">Products</li>
                    <li class="nav-item {{ $productActive ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#productCollapse" role="button"
                           aria-expanded="{{ $productActive ? 'true' : 'false' }}" aria-controls="productCollapse">
                            <i class="link-icon" data-feather="shopping-bag"></i>
                            <span class="link-title">Products</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $productActive ? 'show' : '' }}" id="productCollapse">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('product.create') }}" class="nav-link {{ request()->routeIs('product.create') ? 'active' : '' }}">Add Product</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('product.index') }}" class="nav-link {{ request()->routeIs('product.index', 'product.show', 'product.edit') ? 'active' : '' }}">Show Products</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    {{-- ── Settings ── --}}
                    @php
                        $sliderActive  = request()->routeIs('slider.*');
                        $faqActive     = request()->routeIs('faq.*');
                    @endphp
                    <li class="nav-item nav-category">Settings</li>

                    <li class="nav-item {{ $sliderActive ? 'active' : '' }}">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sliderCollapse" role="button"
                           aria-expanded="{{ $sliderActive ? 'true' : 'false' }}" aria-controls="sliderCollapse">
                            <i class="link-icon" data-feather="image"></i>
                            <span class="link-title">Sliders</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse {{ $sliderActive ? 'show' : '' }}" id="sliderCollapse">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('slider.create') }}" class="nav-link {{ request()->routeIs('slider.create') ? 'active' : '' }}">Add New Slider</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('slider.index') }}" class="nav-link {{ request()->routeIs('slider.index') ? 'active' : '' }}">Manage Sliders</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item {{ request()->routeIs('logo.edit') ? 'active' : '' }}">
                        <a href="{{ route('logo.edit') }}" class="nav-link">
                            <i class="link-icon" data-feather="image"></i>
                            <span class="link-title">Logo Settings</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('hero.index') ? 'active' : '' }}">
                        <a href="{{ route('hero.index') }}" class="nav-link">
                            <i class="link-icon" data-feather="home"></i>
                            <span class="link-title">Hero Section</span>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('footer.edit') ? 'active' : '' }}">
                        <a href="{{ route('footer.edit') }}" class="nav-link">
                            <i class="link-icon" data-feather="share-2"></i>
                            <span class="link-title">Footer Social Links</span>
                        </a>
                    </li>

                    <li class="nav-item {{ $faqActive ? 'active' : '' }}">
                        <a href="{{ route('faq.create') }}" class="nav-link">
                            <i class="link-icon" data-feather="help-circle"></i>
                            <span class="link-title">FAQ</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link bg-transparent border-0 d-flex align-items-center w-100" style="cursor: pointer;">
                                <i class="link-icon" data-feather="log-out"></i>
                                <span class="link-title">Logout</span>
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </nav>
        <!-- /Sidebar -->

        <div class="page-wrapper">

            <!-- Navbar -->
            <nav class="navbar">
                <a href="#" class="sidebar-toggler">
                    <i data-feather="menu"></i>
                </a>
                <div class="navbar-content">
                    <form class="search-form">
                        <div class="input-group">
                            <div class="input-group-text">
                                <i data-feather="search"></i>
                            </div>
                            <input type="text" class="form-control" id="navbarForm" placeholder="Search here...">
                        </div>
                    </form>
                    <ul class="navbar-nav">
                        <li class="nav-item d-none d-md-flex me-3">
                            <a class="nav-link d-flex align-items-center" href="#" role="button">
                                <i data-feather="calendar" class="icon-md text-muted me-1"></i>
                                <span id="currentDate"></span>
                            </a>
                        </li>
                        <li class="nav-item d-none d-md-flex me-3">
                            <a class="nav-link d-flex align-items-center" href="#" role="button">
                                <i data-feather="clock" class="icon-md text-muted me-1"></i>
                                <span id="currentTime"></span>
                            </a>
                        </li>
                        <li class="nav-item d-none d-sm-flex me-3">
                            <a class="nav-link d-flex align-items-center" href="#" role="button">
                                <i data-feather="mail" class="icon-md text-muted me-1"></i>
                                <span>{{ Auth::user()->email }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <!-- /Navbar -->

            <div class="page-content">
                @yield('content')
            </div>

            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
                <p class="text-muted mb-1 mb-md-0">Copyright &copy; 2026 <a href="https://revencomm.com/" target="_blank">Shongini Life Style</a>.</p>
                <p class="text-muted">Designed and Developed by <a href="https://revencomm.com/">RevEnComm</a></p>
            </footer>

        </div>
    </div>

    <!-- core:js -->
    <script src="<?= asset('backend/assets/vendors/core/core.js') ?>"></script>
    <script src="<?= asset('backend/assets/vendors/flatpickr/flatpickr.min.js') ?>"></script>
    <script src="<?= asset('backend/assets/vendors/apexcharts/apexcharts.min.js') ?>"></script>
    <script src="<?= asset('backend/assets/vendors/feather-icons/feather.min.js') ?>"></script>
    <script src="<?= asset('backend/assets/js/template.js') ?>"></script>
    <script src="<?= asset('backend/assets/js/dashboard-dark.js') ?>"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    @stack('scripts')

    <script>
        @if(session('success'))
        toastr.success("{{ session('success') }}");
        @endif
        @if(session('info'))
        toastr.info("{{ session('info') }}");
        @endif
        @if(session('error'))
        toastr.error("{{ session('error') }}");
        @endif
    </script>

    <script>
        function updateDateTime() {
            const now = new Date();
            const dateEl = document.getElementById('currentDate');
            const timeEl = document.getElementById('currentTime');
            if (dateEl) dateEl.textContent = now.toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
            if (timeEl) timeEl.textContent = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>

</body>
</html>
