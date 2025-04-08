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
                                <span class="app-brand-text demo menu-text fw-semibold2" style="text-transform: none; font-size: 20px; color: #333;"><strong>Reset Password U-IKN</strong></span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <form id="resetPasswordForm" class="mb-3" action="{{ route('auth.sendPassword') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="email" class="form-label">email</label>
                                <input type="email" required value="{{ old('email') }}" class="form-control   @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter Your Email" aria-describedby="emailHelp" autofocus />
                                @error('email')
                                <div id="emailHelp" class="form-text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                                @error('login')
                                <div id="emailHelp" class="form-text text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="mb-3 ">
                                <button id="submitBtn" class="btn btn-md btn-primary w-100" type="submit">
                                    <span id="submitText">Reset & send new password</span>
                                    <span id="submitSpinner" class="spinner-border spinner-border-sm text-success d-none" role="status" aria-hidden="true"></span>
                                </button>
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

        document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
            const btn = document.getElementById('submitBtn');
            const text = document.getElementById('submitText');
            const spinner = document.getElementById('submitSpinner');

            text.textContent = 'reseting...';
            spinner.classList.remove('d-none');

            btn.disabled = true;
        });
    </script>
</body>

</html>