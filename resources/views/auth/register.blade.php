<!DOCTYPE html>
<html lang="en">
<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('auth/images/icons/favicon.ico') }}"/>

    <!-- Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/bootstrap/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">

    <!-- Material Design Iconic Font -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/fonts/iconic/css/material-design-iconic-font.min.css') }}">

    <!-- Animations -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/animsition/css/animsition.min.css') }}">

    <!-- Select2 & DateRangePicker -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/vendor/daterangepicker/daterangepicker.css') }}">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/main.css') }}">
    
</head>
<body>

    <div class="limiter">
        <div class="container-login100" style="background-image: url('{{ asset('auth/images/bg-01.jpg') }}');">
            <div class="wrap-login100">
                <form class="login100-form validate-form" method="POST" action="{{ route('register.post') }}">
                    @csrf

                    {{-- Hiển thị thông báo thành công hoặc lỗi --}}
                    @if (session('success'))
                        <div class="alert alert-success text-center">{{ session('success') }}</div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    {{-- Hiển thị lỗi validate --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <span class="login100-form-title p-b-34 p-t-27">
                        Đăng ký tài khoản
                    </span>

                    <!-- Tên đăng nhập -->
                    <div class="wrap-input100 validate-input" data-validate="Tên đăng nhập bắt buộc">
                        <input class="input100" type="text" name="TenDangNhap" placeholder="Tên đăng nhập" value="{{ old('TenDangNhap') }}" required>
                        <span class="focus-input100" data-placeholder="&#xf207;"></span>
                    </div>

                    <!-- Email -->
                    <div class="wrap-input100 validate-input" data-validate="Email hợp lệ là bắt buộc">
                        <input class="input100" type="email" name="Email" placeholder="Email" value="{{ old('Email') }}" required>
                        <span class="focus-input100" data-placeholder="&#xf15a;"></span>
                    </div>

                   <!-- Ngày sinh -->
                    <div class="wrap-input100 validate-input" data-validate="Vui lòng chọn ngày sinh">
                        <input class="input100" type="date" name="NgaySinh" required>
                        
                        <span class="symbol-input100"><i class="fa fa-calendar"></i></span>
                    </div>

                    <!-- Giới tính -->
                    <div class="wrap-input100 validate-input" data-validate="Vui lòng chọn giới tính">
                        <select class="input100" name="GioiTinh" required>
                            <option value="">-- Chọn giới tính --</option>
                            <option value="Nam">Nam</option>
                            <option value="Nữ">Nữ</option>
                            <option value="Khác">Khác</option>
                        </select>
                        
                        <span class="symbol-input100"><i class="fa fa-venus-mars"></i></span>
                    </div>

                    <!-- Địa chỉ -->
                    <div class="wrap-input100 validate-input" data-validate="Vui lòng nhập địa chỉ">
                        <input class="input100" type="text" name="DiaChi" placeholder="Địa chỉ" required>
                        
                        <span class="symbol-input100"><i class="fa fa-map-marker"></i></span>
                    </div>



                    <!-- Mật khẩu -->
                    <div class="wrap-input100 validate-input" data-validate="Nhập mật khẩu">
                        <input class="input100" type="password" name="MatKhau" placeholder="Mật khẩu" required>
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <!-- Xác nhận mật khẩu -->
                    <div class="wrap-input100 validate-input" data-validate="Xác nhận mật khẩu">
                        <input class="input100" type="password" name="MatKhau_confirmation" placeholder="Xác nhận mật khẩu" required>
                        <span class="focus-input100" data-placeholder="&#xf191;"></span>
                    </div>

                    <!-- Checkbox điều khoản -->
                    <div class="contact100-form-checkbox">
                        <input class="input-checkbox100" id="ckb1" type="checkbox" name="terms" required>
                        <label class="label-checkbox100" for="ckb1">
                            Tôi đồng ý với <b>điều khoản sử dụng</b>
                        </label>
                    </div>

                    <!-- Nút đăng ký -->
                    <div class="container-login100-form-btn">
                        <button type="submit" class="login100-form-btn">
                            Đăng ký
                        </button>
                    </div>

                    <!-- Link đăng nhập -->
                    <div class="text-center p-t-90">
                        <a class="txt1" href="{{ route('login') }}">
                            → Đăng nhập
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!-- Scripts -->
    <script src="{{ asset('auth/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('auth/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('auth/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('auth/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('auth/js/main.js') }}"></script>

</body>
</html>
