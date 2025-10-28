<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class Auth extends Model
{
    public function registerUser($data)
    {
        return DB::table('nguoidung')->insert([
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
    }

    /**
     * Kiểm tra đăng nhập
     */
    public function checkLogin($username, $password)
    {
        $user = DB::table('nguoidung')
            ->where('TenDangNhap', $username)
            ->first();
        if (!$user) {
            return null; // Không tồn tại user
        }

        $storedPassword = $user->MatKhau;
        $isBcrypt = str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$2a$');
        // Kiểm tra xem mật khẩu có mã hóa không

        if ($isBcrypt) {
            try {
                return Hash::check($password, $storedPassword) ? $user : null;
            } catch (\Exception $e) {
                // Nếu hash lỗi (chuỗi bị hỏng), coi như sai mật khẩu
                return null;
            }
        }

        if ($storedPassword === $password) {
            DB::table('nguoidung')
                ->where('IDUser', $user->IDUser)
                ->update(['MatKhau' => Hash::make($password)]);

            return $user;
        }

        return null; // Sai mật khẩu
    }
}
