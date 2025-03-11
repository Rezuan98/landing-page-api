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
        .toast-success {
            background-color: #28a745 !important;
            /* Green */
            color: white !important;
        }

        .toast-error {
            background-color: #dc3545 !important;
            /* Red */
            color: white !important;
        }

        .toast-info {
            background-color: #ffc107 !important;
            /* Blue */
            color: white !important;
        }

        .toast-warning {
            background-color: #ffc107 !important;
            /* Yellow */
            color: black !important;
        }

        .toast-title {
            font-weight: bold;
        }

        .toast-message {
            font-size: 14px;
        }

    </style>





</head>
<body>
    <div class="main-wrapper">

        <!-- partial:partials/_sidebar.html -->
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
                    <li class="nav-item nav-category">Main</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">
                            <i class="link-icon" data-feather="box"></i>
                            <span class="link-title">Dashboard</span>
                        </a>
                    </li>

                    <!-- Order Management Section -->
                    <li class="nav-item nav-category">Orders</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#orders" role="button" aria-expanded="false" aria-controls="orders">
                            <i class="link-icon" data-feather="shopping-cart"></i>
                            <span class="link-title">Order Management</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="orders">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}" class="nav-link">All Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=pending" class="nav-link">Pending Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=processing" class="nav-link">Processing Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=completed" class="nav-link">Completed Orders</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('index.order') }}?status=cancelled" class="nav-link">Cancelled Orders</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Product Data Section -->
                    <li class="nav-item nav-category">Product Data</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#sizes" role="button" aria-expanded="false" aria-controls="sizes">
                            <i class="link-icon" data-feather="maximize-2"></i>
                            <span class="link-title">Size</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="sizes">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('size.create') }}" class="nav-link">Add Size</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('size.index') }}" class="nav-link">Show Sizes</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#brands" role="button" aria-expanded="false" aria-controls="brands">
                            <i class="link-icon" data-feather="tag"></i>
                            <span class="link-title">Brand</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="brands">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('brand.create') }}" class="nav-link">Add Brand</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('brand.index') }}" class="nav-link">Show Brands</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Products Section -->
                    <li class="nav-item nav-category">Products</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#products" role="button" aria-expanded="false" aria-controls="products">
                            <i class="link-icon" data-feather="shopping-bag"></i>
                            <span class="link-title">Products</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="products">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="{{ route('product.create') }}" class="nav-link">Add Product</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('product.index') }}" class="nav-link">Show Products</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <!-- Settings Section -->
                    <li class="nav-item nav-category">Settings</li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#banners" role="button" aria-expanded="false" aria-controls="banners">
                            <i class="link-icon" data-feather="image"></i>
                            <span class="link-title">Banners</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="banners">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Hero Banner</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Middle Banner</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">About Banner</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Contact Banner</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#logos" role="button" aria-expanded="false" aria-controls="logos">
                            <i class="link-icon" data-feather="award"></i>
                            <span class="link-title">Logo</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="logos">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Top Logo</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Favicon</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#titles" role="button" aria-expanded="false" aria-controls="titles">
                            <i class="link-icon" data-feather="type"></i>
                            <span class="link-title">Titles</span>
                            <i class="link-arrow" data-feather="chevron-down"></i>
                        </a>
                        <div class="collapse" id="titles">
                            <ul class="nav sub-menu">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Hero Title</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">Footer Title</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="nav-item nav-category">Support</li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="nav-link bg-transparent border-0 d-flex align-items-center w-100" style="cursor: pointer;">
                                <i class="link-icon" data-feather="log-out"></i>
                                <span class="link-title">Logout</span>
                            </button>
                        </form>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('register') }}">Register</a>
                    </li>



                </ul>
            </div>
        </nav>

        <!-- partial -->

        <div class="page-wrapper">

            <!-- partial:partials/_navbar.html -->
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
                        <!-- Current Date & Time -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link d-flex align-items-center" href="#" role="button">
                                <i data-feather="calendar" class="icon-md text-muted me-1"></i>
                                <span id="currentDate"></span>
                            </a>
                        </li>

                        <li class="nav-item dropdown me-3">
                            <a class="nav-link d-flex align-items-center" href="#" role="button">
                                <i data-feather="clock" class="icon-md text-muted me-1"></i>
                                <span id="currentTime"></span>
                            </a>
                        </li>



                        <!-- Admin Email Display -->
                        <li class="nav-item me-3">
                            <a class="nav-link d-flex align-items-center" href="#" role="button">
                                <i data-feather="mail" class="icon-md text-muted me-1"></i>
                                <span>{{ Auth::user()->email }}</span>
                            </a>
                        </li>


                        <!-- User Profile -->

                    </ul>
                </div>
            </nav>
            <!-- partial -->



            <div class="page-content">
                @yield('content')
            </div>


            <!-- partial:partials/_footer.html -->
            <footer class="footer d-flex flex-column flex-md-row align-items-center justify-content-between px-4 py-3 border-top small">
                <p class="text-muted mb-1 mb-md-0">Copyright © 2025 <a href="https://www.nobleui.com" target="_blank">PureHoney</a>.</p>
                <p class="text-muted">Designed and Developed by <a href="https://www.emanagerit.com/">eManagerIt</a></p>
            </footer>
            <!-- partial -->

        </div>
    </div>

    <!-- core:js -->
    <script src="<?= asset('backend/assets/vendors/core/core.js') ?>"></script>
    <!-- endinject -->

    <!-- Plugin js for this page -->
    <script src="<?= asset('backend/assets/vendors/flatpickr/flatpickr.min.js') ?>"></script>
    <script src="<?= asset('backend/assets/vendors/apexcharts/apexcharts.min.js') ?>"></script>
    <!-- End plugin js for this page -->

    <!-- inject:js -->
    <script src="<?= asset('backend/assets/vendors/feather-icons/feather.min.js') ?>"></script>
    <script src="<?= asset('backend/assets/js/template.js') ?>"></script>
    <!-- endinject -->

    <!-- Custom js for this page -->
    <script src="<?= asset('backend/assets/js/dashboard-dark.js') ?>"></script>
    <!-- End custom js for this page -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    {{-- toaster --}}
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
        // Function to update the date and time
        function updateDateTime() {
            const now = new Date();

            // Format date: Mar 11, 2025
            const options = {
                year: 'numeric'
                , month: 'short'
                , day: 'numeric'
            };
            const dateStr = now.toLocaleDateString('en-US', options);

            // Format time with seconds: 12:34:56 PM
            const timeStr = now.toLocaleTimeString('en-US', {
                hour: '2-digit'
                , minute: '2-digit'
                , second: '2-digit'
            });

            // Update the elements
            document.getElementById('currentDate').textContent = dateStr;
            document.getElementById('currentTime').textContent = timeStr;
        }

        // Update initially
        updateDateTime();

        // Update every second for real-time accuracy
        setInterval(updateDateTime, 1000);

    </script>

</body>
</html>
