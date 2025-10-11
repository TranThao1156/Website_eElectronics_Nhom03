<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Auth/images/icons/favicon.ico') }}"/>

    <!-- CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/fonts/iconic/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/css/main.css') }}">
</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('Auth/images/bg-01.jpg') }}');">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('admin.login.post') }}">
                    @csrf
                    
                    <span class="login100-form-logo">
                        <i class="zmdi zmdi-landscape"></i>
                    </span>

                    <span class="login100-form-title p-b-34 p-t-27">
                        Log in
                    </span>

                    <!-- Username -->
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="TenDangNhap" value="{{ old('TenDangNhap') }}" placeholder="Username">
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                        @error('TenDangNhap')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="MatKhau" placeholder="Password">
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                        @error('MatKhau')
                            <span class="text-danger small">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember">
                        <label class="label-checkbox100" for="ckb1">
                            Remember me
                        </label>
                    </div>

                    <!-- Submit button -->
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Login
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="text-center p-t-90">
                        <a class="txt1" href="{{ route('resetpassword') }}">
                            Forgot Password?
                        </a>
                        <a class="txt1" href="{{ route('register') }}">
                            &nbsp;&nbsp;&nbsp;Register?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!-- JS -->
    <script src="{{ asset('Auth/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('Auth/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('Auth/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('Auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('Auth/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('Auth/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('Auth/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('Auth/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('Auth/js/main.js') }}"></script>
</body>
</html>
