<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Auth;
use App\Models\NguoiDung;

class NguoiDungController extends Controller
{
    /**
     * Hiển thị trang đăng nhập
     */
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * Hiển thị trang đăng ký
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Xử lý đăng ký
     */
    public function register(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|min:4|max:50|unique:nguoidung,TenDangNhap',
            'MatKhau'     => 'required|min:6',
        ]);

        $data = $request->only([
            'TenDangNhap', 'MatKhau', 'Email', 'SoDienThoai', 'NgaySinh', 'GioiTinh', 'DiaChi'
        ]);

        // Tạo người dùng mới
        NguoiDung::create([
            'TenDangNhap' => $data['TenDangNhap'],
            'MatKhau'     => Hash::make($data['MatKhau']),
            'Email'       => $data['Email'] ?? null,
            'SoDienThoai' => $data['SoDienThoai'] ?? null,
            'NgaySinh'    => $data['NgaySinh'] ?? null,
            'GioiTinh'    => $data['GioiTinh'] ?? null,
            'DiaChi'      => $data['DiaChi'] ?? null,
            'Role'        => 0,
            'TrangThai'   => 1,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công! Mời đăng nhập.');
    }

    /**
     * Xử lý đăng nhập
     */
    public function login(Request $request)
    {
        $request->validate([
            'TenDangNhap' => 'required|string',
            'MatKhau'     => 'required|string',
        ]);

        $user = DB::table('nguoidung')
            ->where('TenDangNhap', $request->TenDangNhap)
            ->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
        }

        $storedPassword = $user->MatKhau;
        $isBcrypt = str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$');

        // Nếu đã mã hóa
        if ($isBcrypt) {
            try {
                if (!Hash::check($request->MatKhau, $storedPassword)) {
                    return redirect()->back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
                }
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
            }
        } else {
            // Nếu mật khẩu cũ chưa mã hóa → mã hóa lại
            if ($storedPassword === $request->MatKhau) {
                DB::table('nguoidung')
                    ->where('IDUser', $user->IDUser)
                    ->update(['MatKhau' => Hash::make($request->MatKhau)]);
            } else {
                return redirect()->back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
            }
        }

        // Lưu session
        session([
            'user' => [
                'IDUser'      => $user->IDUser,
                'TenDangNhap' => $user->TenDangNhap,
                'Role'        => $user->Role,
            ]
        ]);

        if (intval($user->Role) === 2) {
            session(['admin' => true]);
            return redirect('/backoffice/dashboard')->with('success', 'Đăng nhập quản trị thành công!');
        }

        return redirect('/')->with('success', 'Đăng nhập thành công!');
    }

    /**
     * Đăng xuất
     */
    public function logout()
    {
        session()->forget(['user', 'admin', 'is_admin_logged_in']);
        return redirect()->route('login')->with('success', 'Đã đăng xuất!');
    }
}
