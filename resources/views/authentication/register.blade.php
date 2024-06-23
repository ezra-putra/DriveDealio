<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DriveDealio - Your Trusted Vehicle Auctions and Autoparts</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/app-assets/images/ico/favicon.ico') }}">
    <link href="{{ asset('/app-assets/fonts/monserat.css') }}"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/pages/authentication.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/core/menu/menu-types/horizontal-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/forms/pickers/form-flat-pickr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/forms/pickers/form-pickadate.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style.css') }}">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-4">
                        <!-- Register basic -->
                        <div class="card mb-0">
                            <div class="card-body">
                                <img src="{{ asset('/image/logo-drivedealio.png') }}" class="brand-logo d-block mx-auto mt-2" height="45" width="200" alt="DriveDealio Logo">
                                <form action="{{ route('register.post') }}" method="POST">
                                    @csrf
                                    <div class="bs-stepper-content px-0 mt-2">
                                        <div id="account-details" class="content" role="tabpanel"
                                            aria-labelledby="account-details-trigger">
                                            <div class="content-header mb-2">
                                                <h2 class="fw-bolder mb-75">Account Information</h2>
                                                <span>Enter your username password details</span>
                                            </div>
                                            <div class="col-md-12 mb-1">
                                                <label class="form-label" for="email">Email</label>
                                                <input type="email" name="email" id="email"
                                                    class="form-control" placeholder="john.doe@email.com"
                                                    aria-label="john.doe" />
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <label class="form-label" for="password">Password</label>
                                                    <div
                                                        class="input-group input-group-merge form-password-toggle">
                                                        <input type="password" name="password" id="password"
                                                            class="form-control"
                                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                        <span class="input-group-text cursor-pointer"><i
                                                                data-feather="eye"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <label class="form-label" for="confirm-password">Confirm
                                                        Password</label>
                                                    <div
                                                        class="input-group input-group-merge form-password-toggle">
                                                        <input type="password" name="confirm-password"
                                                            id="confirm-password" class="form-control"
                                                            placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" />
                                                        <span class="input-group-text cursor-pointer"><i
                                                                data-feather="eye"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <label class="form-label" for="fname">Firstname</label>
                                                    <input type="text" name="fname" id="fname"
                                                        class="form-control" placeholder="john" />
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <label class="form-label" for="lname">Lastname</label>
                                                    <input type="text" name="lname" id="lname"
                                                        class="form-control" placeholder="doe" />
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <label class="form-label" for="number">Mobile number</label>
                                                    <input type="text" name="number" id="number"
                                                        class="form-control mobile-number-mask"
                                                        placeholder="(472) 765-3654" />
                                                </div>
                                                <div class="col-md-6 mb-1">
                                                    <label class="form-label" for="birth">Birthdate</label>
                                                    <input type="text" name="birth" id="birth"
                                                        class="form-control flatpickr-human-friendly"
                                                        placeholder="October 14, 2020" />
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center mt-2">
                                                <button class="btn btn-info btn-submit w-100">
                                                    <span
                                                        class="align-middle d-sm-inline-block d-none">Register</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <p class="text-center mt-2">
                                    <span>Already have an account?</span>
                                    <a href="/login">
                                        <span>Sign in instead</span>
                                    </a>
                                </p>
                            </div>
                        </div>
                        <!-- /Register basic -->
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
    <script src="{{ asset('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>

    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('/app-assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('/app-assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('/app-assets/js/scripts/pages/auth-register.js') }}"></script>
    <script src="{{ asset('/app-assets/js/scripts/forms/pickers/form-pickers.js') }}"></script>
    <!-- END: Page JS-->

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
