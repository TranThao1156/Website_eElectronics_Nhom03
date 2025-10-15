<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TaiKhoanController extends Controller
{
    public function showForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Kiểm tra dữ liệu nhập
        $request->validate([
            'TenDangNhap' => 'required|min:4|max:50|unique:nguoidung,TenDangNhap',
            'MatKhau' => 'required|min:6',
            'Email' => 'nullable|email',
            'SoDienThoai' => 'nullable|digits:10',
        ]);

        // Thêm vào CSDL
        DB::table('nguoidung')->insert([
            'TenDangNhap' => $request->TenDangNhap,
            'MatKhau' => Hash::make($request->MatKhau),
            'Email' => $request->Email,
            'SoDienThoai' => $request->SoDienThoai,
            'NgaySinh' => $request->NgaySinh,
            'GioiTinh' => $request->GioiTinh,
            'DiaChi' => $request->DiaChi,
            'TrangThai' => 1,
            'Role' => 0,
        ]);

        // Sau khi đăng ký thành công → chuyển sang trang đăng nhập
        return redirect()->route('user.login')->with('success', 'Đăng ký tài khoản thành công! Mời bạn đăng nhập.');
    }

    public function showLogin()
    {
        return view('auth.login');

    }
}
