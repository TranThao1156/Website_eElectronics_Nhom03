<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('Auth/images/icons/favicon.ico') }}"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">

    <!-- Material Design Iconic Font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/fonts/iconic/css/material-design-iconic-font.min.css') }}">

    <!-- Animations -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/animsition/css/animsition.min.css') }}">

    <!-- Select2 & DateRangePicker -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/css/main.css') }}">
</head>
<body>
    
    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('Auth/images/bg-01.jpg') }}');">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('resetpassword') }}">
                    @csrf

                    <span class="login100-form-title p-b-34 p-t-27">
                        Forgot Password
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Enter your email">
                        <input class="input100" type="email" name="email" placeholder="Email" required>
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Submit
                        </button>
                    </div>

                    <div class="text-center p-t-90">
                        <a class="txt1" href="{{ route('login') }}">
                            ← Sign In
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!-- Scripts -->
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
