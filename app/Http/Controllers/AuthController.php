<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(Auth $authService)
    {
        $this->authService = $authService;
    }

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

        $data = $request->all();

        $this->authService->registerUser($data);

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

        $user = $this->authService->checkLogin($request->TenDangNhap, $request->MatKhau);

        if (!$user) {
            return redirect()->back()->with('error', 'Sai tên đăng nhập hoặc mật khẩu!');
        }

        // Lưu session đúng chuẩn middleware
        session([
            'user' => [
                'IDUser'      => $user->IDUser,
                'TenDangNhap' => $user->TenDangNhap,
                'Role'        => $user->Role,
            ]
        ]);

        if (intval($user->Role) === 2) {
            session(['admin' => true]);
            return redirect()->to('/backoffice/dashboard')->with('success', 'Đăng nhập quản trị thành công!');
        }


        // Người dùng bình thường
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
