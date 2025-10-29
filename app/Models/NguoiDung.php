<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class NguoiDung extends Model
{
    public function getAll() { return DB::table('nguoidung')->get(); }
    public function find($id) { return DB::table('nguoidung')->where('IDUser', $id)->first(); }
    public function findByUsername($username) { return DB::table('nguoidung')->where('TenDangNhap', $username)->first(); }
    public function createUser(array $data) { return DB::table('nguoidung')->insert($data); }
    public function updatePassword($id, $newPassword)
    {
        return DB::table('nguoidung')->where('IDUser', $id)->update(['MatKhau' => $newPassword]);
    }
}
