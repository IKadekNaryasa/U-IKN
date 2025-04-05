<!DOCTYPE html>
<html
    lang="en"
    class="light-style customizer-hide"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="{{ asset('ikn_sneat') }}/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('ikn_sneat') }}/assets/img/favicon/favicon.ico ?v={{ time() }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="{{ asset('ikn_sneat') }}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('ikn_sneat') }}/assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('ikn_sneat') }}/assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('ikn_sneat') }}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('ikn_sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('ikn_sneat') }}/assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="{{ asset('ikn_sneat') }}/assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('ikn_sneat') }}/assets/js/config.js"></script>
</head>

<body>
    @if (session('success'))
    <div
        id="errorToast"
        class="bs-toast toast toast-placement-ex m-2  position-fixed top-0 end-0 bg-success"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="2000"
        data-bs-autohide="true">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Success!</div>
            <small>{{ date('l, d F Y') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">{{session('success')}}</div>
    </div>
    @endif
    @if (session('error'))
    <div
        id="errorToast"
        class="bs-toast toast toast-placement-ex m-2  position-fixed top-0 end-0 bg-danger"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        data-bs-delay="2000"
        data-bs-autohide="true">
        <div class="toast-header">
            <i class="bx bx-bell me-2"></i>
            <div class="me-auto fw-semibold">Warning!</div>
            <small>{{ date('l, d F Y') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">{{session('error')}}</div>
    </div>
    @endif

    <!-- Content -->
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <!-- Register -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center">
                            <a href="index.html" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">
                                    <!-- <img src="{{ asset('ikn_sneat/assets/img/icons/brands/toolkit.png') }}" alt="ToolKit" width="50"> -->
                                </span>
                                <span class="app-brand-text demo menu-text fw-semibold2" style="text-transform: none; font-size: 20px; color: #333;"><strong>U-IKN</strong></span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <form id="formAuthentication" class="mb-3" action="{{ route('auth.auth') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Username</label>
                                <input type="text" required value="{{ old('username') }}" class="form-control   @error('username') is-invalid @enderror" id="username" name="username" placeholder="Enter username" aria-describedby="usernameHelp" autofocus />
                                @error('username')
                                <div id="usernameHelp" class="form-text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                                @error('login')
                                <div id="usernameHelp" class="form-text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <div class="d-flex justify-content-between">
                                    <label class="form-label" for="password">Password</label>
                                </div>
                                <div class="input-group input-group-merge">
                                    <input type="password" required id="password" class="form-control   @error('password') is-invalid @enderror" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                                <a href="">
                                    <small>Forgot Password?</small>
                                </a>
                                @error('password')
                                <div id="passwordHelp" class="form-text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <!-- <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember-me" />
                                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                                </div>
                            </div> -->
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Register -->
            </div>
        </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('ikn_sneat') }}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{ asset('ikn_sneat') }}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{ asset('ikn_sneat') }}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{ asset('ikn_sneat') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

    <script src="{{ asset('ikn_sneat') }}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('ikn_sneat') }}/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{ asset('ikn_sneat') }}/assets/js/ui-toasts.js"></script>


    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var errorToastEl = document.getElementById("errorToast");
            if (errorToastEl) {
                var toast = new bootstrap.Toast(errorToastEl);
                toast.show();
            }
        });
    </script>
</body>

</html>