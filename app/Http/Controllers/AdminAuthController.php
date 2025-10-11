<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminAuthController extends Controller
{
    // 🧩 Hiển thị form đăng nhập Admin
    public function showLoginForm()
    {
        return view('auth.login'); // file: resources/views/auth/login.blade.php
    }

    // 🧩 Xử lý khi nhấn nút "Đăng nhập"
    public function login(Request $request)
    {
        // Bước 1: Validate dữ liệu nhập
        $request->validate([
            'TenDangNhap' => 'required',
            'MatKhau' => 'required',
        ]);

        // Bước 2: Tìm user theo tên đăng nhập
        $user = User::where('TenDangNhap', $request->TenDangNhap)->first();

        // Bước 3: Kiểm tra tồn tại
        if (!$user) {
            return back()->withErrors(['TenDangNhap' => 'Tên đăng nhập không tồn tại.']);
        }

        // Bước 4: Kiểm tra mật khẩu
        if (!Hash::check($request->MatKhau, $user->MatKhau)) {
            return back()->withErrors(['MatKhau' => 'Mật khẩu không đúng.']);
        }

        // Bước 5: Kiểm tra trạng thái hoạt động
        if ($user->TrangThai != 1) {
            return back()->withErrors(['TenDangNhap' => 'Tài khoản đang bị khóa.']);
        }

        // Bước 6: Kiểm tra quyền
        if ($user->Role != 2) {
            return back()->withErrors(['TenDangNhap' => 'Bạn không có quyền truy cập trang quản trị.']);
        }

        // ✅ Bước 7: Đăng nhập thủ công
        Auth::loginUsingId($user->IDUser);

        // Chuyển hướng đến trang Dashboard admin
        return redirect()->route('admin.dashboard')->with('success', 'Đăng nhập thành công!');
    }

    // 🧩 Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.login')->with('success', 'Đã đăng xuất!');
    }
}
