<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log; 

class AuthMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cho phép truy cập login/register không cần đăng nhập
        if (
            $request->is('login') || $request->is('login*') ||
            $request->is('register') || $request->is('register*')
            ) 
            {
            return $next($request);
        }

        // Kiểm tra nếu session chưa khởi tạo
        if (! $request->hasSession()) {
            return redirect()->route('login')->with('error', 'Session chưa được khởi tạo!');
        }

        $session = $request->session();
        $user = $session->get('user');

        // Kiểm tra đăng nhập
        if (! $user || ! (is_array($user) && isset($user['IDUser'])) && ! (is_object($user) && property_exists($user, 'IDUser'))) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để tiếp tục!');
        }

        // Người dùng hợp lệ → Ghi log vào file riêng auth.log
        $userId = is_array($user) ? $user['IDUser'] : $user->IDUser;
        $userName = is_array($user) ? ($user['TenDangNhap'] ?? 'Không rõ tên') : ($user->Ten ?? 'Không rõ tên');
        $ipAddress = $request->ip();
        $accessTime = now()->format('Y-m-d H:i:s');
        $path = $request->path();

        // Ghi log chi tiết vào file riêng
        Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/auth.log'),
        ])->info("[{$accessTime}] Người dùng: {$userName} (ID: {$userId}) | IP: {$ipAddress} | Truy cập: {$path}");

        return $next($request);
    }
}
