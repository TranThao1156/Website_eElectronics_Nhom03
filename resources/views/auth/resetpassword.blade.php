<!DOCTYPE html>
<html lang="en">
<head>
    <title>Đổi mật khẩu</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('Auth/images/icons/favicon.ico') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/vendor/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('Auth/fonts/iconic/css/material-design-iconic-font.min.css') }}">
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
                    Đổi mật khẩu
                </span>

                <!-- Mật khẩu hiện tại -->
                <div class="wrap-input100 validate-input" data-validate="Vui lòng nhập mật khẩu hiện tại">
                    <input class="input100" type="password" name="current_password" placeholder="Mật khẩu hiện tại" required>
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <!-- Mật khẩu mới -->
                <div class="wrap-input100 validate-input" data-validate="Vui lòng nhập mật khẩu mới">
                    <input class="input100" type="password" name="new_password" placeholder="Mật khẩu mới" required>
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <!-- Xác nhận mật khẩu -->
                <div class="wrap-input100 validate-input" data-validate="Vui lòng xác nhận mật khẩu mới">
                    <input class="input100" type="password" name="new_password_confirmation" placeholder="Xác nhận mật khẩu mới" required>
                    <span class="focus-input100" data-placeholder="&#xf191;"></span>
                </div>

                <!-- Nút Đổi mật khẩu -->
                <div class="container-login100-form-btn">
                    <button class="login100-form-btn">
                        Đổi mật khẩu
                    </button>
                </div>
                <!-- Nút đăng nhập -->
                <div class="text-center p-t-10">
                    <a class="txt1" href="{{ route('login') }}">
                        <i class="zmdi zmdi-account"></i> Đăng nhập
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="{{ asset('Auth/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('Auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('Auth/js/main.js') }}"></script>
</body>
</html>
