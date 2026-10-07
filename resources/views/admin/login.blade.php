{{-- @include('layouts.admin_app') --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title> Ads Manager - Login</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/skyraan-technologies.avif') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.0.96/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-Avb2QiuDEEvB4bZJYdft2mNjVShBftLdPG8FJ0V7irTLQ8Uo0qcPxh4Plq7G5tGm0rU+1SPhVotteLpBERwTkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link href="{{ asset('assets/css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/login_page.css') }}" rel="stylesheet">

    <style>
        .container-login100::before {
            content: "";
            display: block;
            position: absolute;
            z-index: -1;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-image: url('{{ url('assets/img/img-01.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="overflow-hidden">

    <main style="background-color: #bfd6ec;min-height: 100vh;">
        {{-- <div class="limiter"> --}}
        <div class="container-login100">

            <div id="pre-loader" class="pre-loader">
                <div class="loader">
                </div>
            </div>

            <div class="container">

                <header class="mt-3"
                    style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
                    <div class="logo"></div>
                    <div class="menu">
                        <div class="d-flex justify-content-center align-content-center align-items-center">
                            <i class="fa fa-solid fa-rectangle-ad" style="font-size: 30px;"></i>
                            <h2>&nbsp;: Comprehensive Advertising Control and Management Dashboard</h2>
                        </div>
                    </div>
                </header>

                <section class="section register d-flex flex-column align-items-center justify-content-center py-4">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center"
                                style="padding-bottom:114px;overflow:hidden;">
                                <div class="card"
                                    style="box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);">
                                    @php
                                        $currentDateTime = \Carbon\Carbon::now();
                                        $formattedDateTime = $currentDateTime->format('D d, M Y');
                                    @endphp
                                    <div class="card-body" style="background-color: #FFFFFF;">
                                        <div class="float-end mt-1">
                                            <h5 class="form-label fw-bold"
                                                style="text-transform: uppercase!important;color:#0858cf !important  ">
                                                {{ $formattedDateTime }}</h5>
                                        </div>
                                        <br>
                                        <div class="pt-4 text-center">
                                            <img src="{{ asset('assets/img/skyraan-technologies.avif') }}"
                                                width="15%" />
                                        </div>
                                        {{-- <div
                                            class="d-flex justify-content-center align-content-center align-items-center">
                                            <h5 class="card-title text-center pb-0 fs-4"><i class="fa fa-brands fa-adversal"
                                                    style="font-size: 25px;margin-top:5px;"></i> Ads Management Dashboard</h5>
                                        </div> --}}
                                        <p class="text-center small pb-0">Log into your account</p>

                                        <form class="row g-3 needs-validation" id="validation_form" method="POST"
                                            action="{{ route('admin.auth') }}" novalidate>
                                            @csrf

                                            <div class="col-12">
                                                <label for="yourUsername" class="form-label fw-bold"
                                                    style="text-transform: uppercase!important;  ">Username / Email
                                                    <span class="text-danger">*</span> </label>
                                                <div class="input-group has-validation">
                                                    <input type="email" name="email" class="form-control"
                                                        id="yourUsername" value="{{ old('email') }}"
                                                        placeholder="Enter a Email here!..." required
                                                        style="height: 41px;">
                                                    <div class="invalid-feedback">Please enter your Email.</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label for="yourPassword" class="form-label fw-bold"
                                                    style="text-transform: uppercase!important;  ">Password <span
                                                        class="text-danger">*</span> </label>
                                                <div class="input-group mb-1">
                                                    <input type="password" name="password" class="form-control"
                                                        id="yourPassword" value="{{ old('password') }}"
                                                        placeholder="Enter a Password here!..." required>
                                                    <span class="input-group-text"
                                                        style="border-top-right-radius:7px;border-bottom-right-radius:7px;cursor: pointer;"><i
                                                            class="mdi mdi-eye-off mdi-18px" aria-hidden="true"
                                                            id="togglePassword"></i></span>
                                                    <div class="invalid-feedback">Please enter your password!</div>
                                                    <div class="valid-feedback">Looks good!</div>
                                                </div>
                                            </div>


                                            <div class="col-12">
                                                <label for="key" class="form-label fw-bold"
                                                    style="text-transform: uppercase!important;  ">Unlock Your
                                                    Account <span
                                                        class="text-danger">*</span> </label>
                                                <input type="text" name="password2"
                                                    value="{{ old('password2') }}" class="form-control key-input"
                                                    id="key" placeholder="Enter a key to login here!..." required
                                                    autocomplete="off">
                                                <div class="invalid-feedback">Please enter your secret key!</div>
                                            </div>


                                            <div class="col-12 text-center">

                                                @if ($errors->has('captcha'))
                                                    <span class="help-block">
                                                        <div class="text-danger">
                                                            <strong>{{ $errors->first('captcha') }}</strong></div>
                                                    </span>
                                                @endif

                                                <a class="btn btn-primary" id="loginLink"
                                                    style="background-color: #1269db !important;border: 1px solid #1269db;">Gain
                                                    access</a>

                                                <div id="demo-modal" class="modal">
                                                    <div class="modal__content">
                                                        <label for="key" class="form-label fw-bold">Unlock Your
                                                            Account</label>
                                                        <div class="captcha">
                                                            <span>{!! captcha_img('flat', ['characters' => '0123456789', 'class' => 'img-responsive'], 'numeric', 4) !!}</span>
                                                            <button type="button" onclick="refreshCaptcha()"
                                                                class="btn btn-success btn-refresh btn-sm"><i
                                                                    class="fa fa-refresh"></i></button>
                                                        </div>
                                                        <div class="col-12 mt-2">
                                                            <div class="email-otp-container">
                                                                <!-- Six input fields for OTP digits -->
                                                                <input type="text" class="email-otp-input"
                                                                    maxlength="1" name="captcha1">
                                                                <input type="text" class="email-otp-input"
                                                                    pattern="\d" maxlength="1" disabled
                                                                    name="captcha2">
                                                                <input type="text" class="email-otp-input"
                                                                    pattern="\d" maxlength="1" disabled
                                                                    name="captcha3">
                                                                <input type="text" class="email-otp-input"
                                                                    pattern="\d" maxlength="1" name="captcha4"
                                                                    disabled>
                                                            </div>
                                                            <!-- Field to display entered OTP -->
                                                            <input type="text" id="emailverificationCode"
                                                                placeholder="Enter verification code" readonly hidden>
                                                        </div>
                                                        <br>
                                                        <button type="button" class="btn btn-primary"
                                                            id="login_for_submit" data-bs-dismiss="modal">Sign
                                                            In</button>
                                                        <a class="modal__close" id="modalCloseButton"
                                                            style="cursor: pointer">&times;</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>

                                <div class="credits">
                                </div>

                            </div>
                        </div>
                    </div>

                </section>

            </div>
        </div>
        {{-- </div> --}}
    </main><!-- End #main -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/echarts/echarts.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" crossorigin="anonymous"
        referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <script>
        function refreshCaptcha() {
            var captchaImage = document.querySelector('.captcha img');
            captchaImage.src = captchaImage.src.split('?')[0] + '?' + Math.random();
            $('.email-otp-input').val('');
        }

        const modal = document.getElementById("demo-modal");
        const loginLink = document.getElementById("loginLink");
        const modalCloseButton = document.getElementById("modalCloseButton");

        loginLink.addEventListener("click", function(event) {
            event.preventDefault();
            modal.style.visibility = "visible";
            modal.style.opacity = "1";
        });

        modalCloseButton.addEventListener("click", function() {
            modal.style.visibility = "hidden";
            modal.style.opacity = "0";
        });
    </script>
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#yourPassword');
        togglePassword.addEventListener('click', () => {
            if (password.getAttribute('type') == 'password') {
                $('#togglePassword').removeClass('mdi-eye-off');
                $('#togglePassword').addClass('mdi-eye');
            } else {
                $('#togglePassword').addClass('mdi-eye-off');
                $('#togglePassword').removeClass('mdi-eye');
            }
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
        });
    </script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "newestOnTop": false,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "preventDuplicates": true,
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @elseif (Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @elseif (Session::has('message'))
                toastr.success("{{ Session::get('message') }}");
            @endif
        });

        $('#login_for_submit').on('click', function() {
            if (1 == 1) {
                $('#pre-loader').removeClass('active-is');
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": false,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": true,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                }
                $('#login_for_submit').addClass('bg-secondary');
                $('#login_for_submit').css('background', 'none');
                $('#login_for_submit').text('Signing In..');
                if ($('#yourPassword').val() == "" || $('#yourUsername').val() == "") {
                    if ($('#yourPassword').val() == "") {
                        toastr.error("Authenticating Failed …");
                        $('#yourPassword').addClass('is-invalid');
                        $('#login_for_submit').css('background', '#1e2844');
                        $('#login_for_submit').text('Sign In');
                    }
                    if ($('#yourUsername').val() == "") {
                        $('#yourUsername').addClass('is-invalid');
                        toastr.error("Authenticating Failed …");
                        $('#login_for_submit').css('background', '#1e2844');
                        $('#login_for_submit').text('Sign In');
                    }
                } else {

                    $('#login_for_submit').addClass('bg-secondary');
                    $('#login_for_submit').css('background', 'none');
                    $('#login_for_submit').text('Signing In..');
                    // $('#login_for_submit').html('<span class="fa fa-spinner fa-2x fa-spin"></span>');

                    $('#yourUsername').removeClass('is-invalid');
                    $('#yourPassword').removeClass('is-invalid');
                    toastr.success("Login successful. Redirecting …");

                    setTimeout(() => {
                        let overlay = document.getElementsByClassName('pre-loader')[0];
                        overlay.classList.toggle('is-active');
                        $('#validation_form').submit();
                    }, 500);
                }
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var otpInputs = document.querySelectorAll(".otp-input");
            var emailOtpInputs = document.querySelectorAll(".email-otp-input");

            function setupOtpInputListeners(inputs) {
                inputs.forEach(function(input, index) {
                    input.addEventListener("paste", function(ev) {
                        var clip = ev.clipboardData.getData('text').trim();
                        if (!/^[a-zA-Z0-9]{6}$/.test(clip)) {
                            ev.preventDefault();
                            return;
                        }

                        var characters = clip.split("");
                        inputs.forEach(function(otpInput, i) {
                            otpInput.value = characters[i] || "";
                        });

                        enableNextBox(inputs[0], 0);
                        inputs[3].removeAttribute("disabled");
                        inputs[3].focus();
                        updateOTPValue(inputs);
                    });

                    input.addEventListener("input", function() {
                        var currentIndex = Array.from(inputs).indexOf(this);
                        var inputValue = this.value.trim();
                        if (inputValue && currentIndex < 3) {
                            inputs[currentIndex + 1].removeAttribute("disabled");
                            inputs[currentIndex + 1].focus();
                        }

                        if (currentIndex === 3 && inputValue) {
                            inputs[3].removeAttribute("disabled");
                            inputs[3].focus();
                        }

                        updateOTPValue(inputs);
                    });

                    input.addEventListener("keydown", function(ev) {
                        var currentIndex = Array.from(inputs).indexOf(this);

                        if (!this.value && ev.key === "Backspace" && currentIndex > 0) {
                            inputs[currentIndex - 1].focus();
                        }
                    });
                });
            }

            function enableNextBox(input, currentIndex) {
                var inputValue = input.value;

                if (inputValue === "") {
                    return;
                }

                var nextIndex = currentIndex + 1;
                var nextBox = otpInputs[nextIndex] || emailOtpInputs[nextIndex];

                if (nextBox) {
                    nextBox.removeAttribute("disabled");
                }
            }

            function updateOTPValue(inputs) {
                var otpValue = "";

                inputs.forEach(function(input) {
                    otpValue += input.value;
                });

                if (inputs === otpInputs) {
                    document.getElementById("verificationCode").value = otpValue;
                } else if (inputs === emailOtpInputs) {
                    document.getElementById("emailverificationCode").value = otpValue;
                }
            }

            setupOtpInputListeners(otpInputs);
            setupOtpInputListeners(emailOtpInputs);

            // otpInputs[0].focus(); // Set focus on the first OTP input field
            emailOtpInputs[0].focus(); // Set focus on the first email OTP input field

            // otpInputs[5].addEventListener("input", function () {
            //   updateOTPValue(otpInputs);
            // });
        });
    </script>
</body>

</html>
