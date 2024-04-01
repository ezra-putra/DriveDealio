<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="author" content="PIXINVENT">
    <title>DriveDealio - Your Trusted Vehicle Auctions and Autoparts</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/app-assets/images/ico/favicon.ico') }}">
    <link href="{{ asset('/app-assets/fonts/monserat.css') }}"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->


    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/extensions/nouislider.min.css') }}">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/extensions/toastr.min.css">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/select/select2.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/extensions/swiper.min.css') }}">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/colors/palette-gradient.css">

    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/extensions/ext-component-sliders.css') }}">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/extensions/ext-component-toastr.css">


    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/forms/wizard/bs-stepper.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-wizard.css">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/page-pricing.css">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/calendars/fullcalendar.min.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css">
    {{-- flaction link --}}

    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/css/plugins/extensions/ext-component-sliders.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-ecommerce.css">
    <link rel="stylesheet" type="text/css"
        href="../../../app-assets/css/plugins/extensions/ext-component-toastr.css">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/pickers/form-flat-pickr.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-calendar.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-validation.css">


    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/forms/form-validation.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu 1-column navbar-floating footer-static " data-open="hover"
    data-menu="horizontal-menu" data-col="1-column" style="background-color: white">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-fixed text-center mx-auto navbar-shadow"
        style="background-color: white; justify-content: center;">
        <div class="navbar-header ml-auto ms-5 me-2 mx-auto text-center justify-content-center">
            @if (auth()->user())
                @if (auth()->user()->roles_id == 2)
                    <a href="/" class="navbar-brand h1">
                        <img src="{{ asset('/image/logo-drivedealio.png') }}" alt="Logo" class="img-fluid" width="170" height="120">
                    </a>
                @endif
                @if (auth()->user()->roles_id == 1)
                    <a href="/admin/dashboard" class="navbar-brand h1">
                        <img src="{{ asset('/image/logo-drivedealio.png') }}" alt="Logo" class="img-fluid" width="170" height="120">
                    </a>
                @endif
                @if (auth()->user()->roles_id == 3)
                    <a href="/inspector/dashboard" class="navbar-brand h1">
                        <img src="{{ asset('/image/logo-drivedealio.png') }}" alt="Logo" class="img-fluid" width="170" height="120">
                    </a>
                @endif
                @if (auth()->user()->roles_id == 4)
                    <a href="/courier/dashboard" class="navbar-brand h1">
                        <img src="{{ asset('/image/logo-drivedealio.png') }}" alt="Logo" class="img-fluid" width="170" height="120">
                    </a>
                @endif
            @else
                <a href="/" class="navbar-brand h1">
                    <img src="{{ asset('/image/logo-drivedealio.png') }}" alt="Logo" class="img-fluid" width="170" height="120">
                </a>
            @endif
        </div>
        <div class="navbar-container container-fluid">
            <div class="collapse navbar-collapse" id="navbar-static-collapse">
                <!-- Search Bar -->
                <form action="{{ route('search.items') }}" method="GET">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Search">
                        <button class="btn btn-outline-primary" type="submit">Search</button>
                    </div>
                </form>

                <!-- Navigation Links -->
                <ul class="nav navbar-nav my-2 justify-content-start ms-1">
                    <li class="nav-item">
                        <a href="/vehicle/car" class="nav-link d-flex align-items-center">Cars</a>
                    </li>
                    <li class="nav-item">
                        <a href="/vehicle/motorcycle" class="nav-link d-flex align-items-center">Motorcycles</a>
                    </li>
                    <li class="nav-item">
                        <a href="/sparepart" class="nav-link d-flex align-items-center">Spareparts</a>
                    </li>
                    <li class="nav-item">
                        <a href="/auction" class="nav-link d-flex align-items-center">Auctions</a>
                    </li>
                    <li class="nav-item">
                        <a href="/membership/bilings" class="nav-link d-flex align-items-center">Memberships</a>
                    </li>
                    <li class="nav-item">
                        <a href="/vehicle/adddata" class="nav-link d-flex align-items-center">Sell My Vehicle</a>
                    </li>
                </ul>

                <!-- User Links -->
                <ul class="nav navbar-nav p-1 ms-1">
                    <li class="nav-item">
                        <a href="/wishlist" class="btn btn-icon">
                            <i class="fa fa-heart"></i>
                        </a>
                    </li>

                    <li class="nav-item dropdown dropdown-notification">
                        @if (auth()->user())
                        <span class="badge rounded-pill bg-danger badge-up">1</span>
                        @else
                        <span class="badge rounded-pill bg-danger badge-up">0</span>
                        @endif
                        <a href="/cart" class="btn btn-icon">
                            <i class="fa fa-shopping-cart"></i>
                        </a>
                    </li>
                    @if (auth()->user())
                    <li class="nav-item dropdown dropdown-notification">
                        <span class="badge rounded-pill bg-danger badge-up">{{ auth()->user()->unreadNotifications->count() }}</span>
                        <a href="#" class="btn btn-icon" data-bs-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header d-flex">
                                    <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">
                                @forelse ( auth()->user()->unreadNotifications as $n )
                                <a class="d-flex" href="#">
                                    <div class="list-item d-flex align-items-start">
                                        <div class="list-item-body flex-grow-1">
                                            <p class="media-heading">
                                                <span class="fw-bolder">
                                                    {{ $n->data['title'] }}</span>
                                            </p>
                                            <small class="notification-text" style="font-weight: 600;">
                                                {{ $n->data['messages'] }}
                                            </small>
                                        </div>
                                    </div>
                                </a>
                                @empty
                                <p class="ms-2 mt-1">No Notifications</p>
                                @endforelse
                            </li>
                            <li class="dropdown-menu-footer">
                                <a class="btn btn-primary w-100" href="{{ route('mark-as-read') }}">Read all notifications</a>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item dropdown dropdown-notification ">
                        <span class="badge rounded-pill bg-danger badge-up">0</span>
                        <a href="#" class="btn btn-icon" data-bs-toggle="dropdown">
                            <i class="fa fa-bell"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-end">
                            <li class="dropdown-menu-header">
                                <div class="dropdown-header d-flex">
                                    <h4 class="notification-title mb-0 me-auto">Notifications</h4>
                                </div>
                            </li>
                            <li class="scrollable-container media-list">
                                <p class="ms-2 mt-1">No Notifications</p>
                            </li>
                        </ul>
                    </li>
                    @endif
                    @if (auth()->user())
                        <li class="nav-item dropdown dropdown-user ms-1">
                            <a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="avatar"><img class="round" src="{{ auth()->user()->profilepicture }}"
                                    alt="avatar" height="40" width="40" style="object-fit: cover">
                                    <span class="avatar-status-online"></span>
                                </span>
                                <div class="user-nav d-sm-flex d-none ms-1">
                                    <span
                                        class="user-name fw-bolder">{{ auth()->user()->firstname }}
                                    </span>
                                </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                                <a class="dropdown-item" href="/profile">
                                    <i class="me-50" data-feather="user"></i>Profile</a>
                                <a class="dropdown-item" href="/orderhistory">
                                    <i class="me-50" data-feather="file-text"></i>Transaction</a>
                                @if (auth()->user()->roles_id === 1)
                                    <a class="dropdown-item" href="/"><i
                                            class="fa fa-shopping-cart me-50"></i>To E-Commerce</a>
                                @endif

                                @if (auth()->user()->roles_id === 3)
                                    <a class="dropdown-item" href="/inspector/listvehicle"><i
                                            class="fa fa-car me-50"></i>Vehicle List</a>
                                @endif

                                @if (auth()->user()->roles_id === 2)
                                    @if (auth()->user()->sellerstatus == false)
                                        <a class="dropdown-item" href="/seller/register"><i
                                                class="fa fa-handshake-o me-50"></i>Become a Seller</a>
                                    @else
                                        <a class="dropdown-item" href="/seller/dashboard"><i
                                                class="fa fa-bar-chart me-50"></i>Seller Dashboard</a>
                                    @endif
                                    <a class="dropdown-item" href="/vehicle/myvehicle"><i
                                            class="fa fa-car me-50"></i>MyVehicle List</a>
                                @endif
                                <div class="dropdown-divider"></div>
                                {{-- <a class="dropdown-item nav-link nav-link-style">
                                <i class="me-50" data-feather="moon"></i>Dark Mode</a> --}}
                                <form action="{{ route('logout') }}" method="GET">
                                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="me-50"
                                            data-feather="power"></i> Logout</a>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item mx-2">
                            <a href="/login" class="btn btn-outline-primary">Login</a>
                        </li>
                        <li class="nav-item mx-0.5">
                            <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>




    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->

    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        @if (session('error'))
            <div id="errorPopup"
                style="display: none; background-color: #ff8080; color: #fff; padding: 10px; position: fixed; top: 15%; left: 50%; transform: translateX(-50%); z-index: 1000;">
                {{ session('error') }}
            </div>
            <script>
                document.getElementById('errorPopup').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('errorPopup').style.display = 'none';
                }, 10000);
            </script>
        @endif
        @if (session('success'))
            <div id="successPopup"
                style="display: none; background-color: #80ff80; color: #000; padding: 10px; position: fixed; top: 15%; left: 50%; transform: translateX(-50%); z-index: 1000;">
                {{ session('success') }}
            </div>
            <script>
                document.getElementById('successPopup').style.display = 'block';
                setTimeout(function() {
                    document.getElementById('successPopup').style.display = 'none';
                }, 10000);
            </script>
        @endif
        @yield('content')
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">

    </footer>
    <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/wNumb.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/nouislider.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/toastr.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/pages/app-ecommerce.js"></script>
    <!-- END: Page JS-->

    {{-- Swipper --}}
    <!-- BEGIN: Vendor JS -->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../../../app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/swiper.min.js"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/js/scripts/pages/app-ecommerce-details.js"></script>

    <script src="../../../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- END: Page JS-->
    {{-- End Swipper --}}

    {{-- Start Recommendation --}}
    <!-- BEGIN: Vendor JS-->
    <script src="../../../app-assets/vendors/js/vendors.min.js"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>

    <script src="../../../app-assets/vendors/js/extensions/moment.min.js"></script>
    <script src="../../../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
    <script src="../../../app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js"></script>


    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="../../../app-assets/vendors/js/file-uploaders/dropzone.min.js"></script>

    <script src="../../../app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script src="../../../app-assets/vendors/js/forms/wizard/bs-stepper.min.js"></script>
    <script src="../../../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <script src="../../../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>

    <script src="../../../app-assets/js/scripts/extensions/ext-component-swiper.js"></script>

    <script src="../../../app-assets/js/scripts/pages/page-pricing.js"></script>

    <script src="../../../app-assets/js/scripts/pages/app-calendar-events.js"></script>

    <script src="../../../app-assets/js/scripts/forms/form-wizard.js"></script>
    <!-- END: Page JS-->
    {{-- End Recommendation --}}

    {{-- Start For input form --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/parsley.js/2.9.2/parsley.min.js"
        integrity="sha512-eyHL1atYNycXNXZMDndxrDhNAegH2BDWt1TmkXJPoGf1WLlNYt08CSjkqF5lnCRmdm3IrkHid8s2jOUY4NIZVQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- End For Input form --}}

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>
