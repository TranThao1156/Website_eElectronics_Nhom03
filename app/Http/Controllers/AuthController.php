<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AuthController extends Controller
{
    // Hiển thị form đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Hiển thị form đăng ký
    public function showRegister()
    {
        return view('auth.register');
    }

    // Xử lý đăng ký (dùng DB facade, không dùng model)
    public function register(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|string|max:50|unique:nguoidung,TenDangNhap',
            'Email' => 'required|email|unique:nguoidung,Email',
            'MatKhau' => 'required|string|min:6|confirmed',
            'SoDienThoai' => 'nullable|string|max:20',
            'NgaySinh' => 'nullable|date',
            'GioiTinh' => 'nullable|string|max:10',
            'DiaChi' => 'nullable|string|max:255',
        ]);

        
            DB::table('nguoidung')->insert([
                'TenDangNhap' => $request->TenDangNhap,
                // 'MatKhau' => Hash::make($request->MatKhau),//Mã hóa mật khẩu
                'MatKhau' => $request->MatKhau,
                'Email' => $request->Email,
                'SoDienThoai' => $request->SoDienThoai,
                'NgaySinh' => $request->NgaySinh,
                'GioiTinh' => $request->GioiTinh,
                'DiaChi' => $request->DiaChi,
                'TrangThai' => 1,
                'Role' => 0,
                
            ]);
        
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    // Xử lý đăng nhập
    public function login(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|string',
            'MatKhau' => 'required|string',
        ]);

        $user = DB::table('nguoidung')->where('TenDangNhap', $request->TenDangNhap)->first();

        // if ($user && Hash::check($request->MatKhau, $user->MatKhau)) {// dùng khi ma hóa mật khẩu
        //     session(['user' => $user]);
        //     return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        // }
         if ($user && $request->MatKhau === $user->MatKhau) {
            session(['user' => $user]);
            if ($user->Role == 1) {
                return redirect('/backoffice/add_product')->with('success', 'Đăng nhập thành công!');
            } else {
                return redirect()->route('home')->with('success', 'Đăng nhập thành công (Người dùng)!');
            }
        }
    }

    public function resetPassword(Request $request)
        {   
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = session('user');

        // Lấy user từ database
        $dbUser = DB::table('nguoidung')->where('IDUser', $user->IDUser)->first();

        if (!$dbUser || !Hash::check($request->current_password, $dbUser->MatKhau)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        // Cập nhật mật khẩu mới
        DB::table('nguoidung')
            ->where('IDUser', $user->IDUser)
            ->update(['MatKhau' => Hash::make($request->new_password)]);

        // Xóa session và yêu cầu đăng nhập lại
        session()->forget('user');

        return redirect()->route('login')->with('success', 'Đổi mật khẩu thành công! Vui lòng đăng nhập lại.');
    }

    // Đăng xuất
    // public function logout()
    // {
    //     session()->forget('user');
    //     return redirect()->route('login')->with('success', 'Bạn đã đăng xuất!');
    // }

    // Dashboard (ví dụ)
  
}
