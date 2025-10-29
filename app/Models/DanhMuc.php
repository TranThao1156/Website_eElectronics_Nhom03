<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class DanhMuc extends Model
{
    protected $table = 'danhmuc';
    protected $primaryKey = 'MaDanhMuc';
    public $timestamps = true;

    // 🔹 Thêm danh mục mới bằng query thuần
    public static function insertRaw($tenDanhMuc)
    {
        return DB::insert(
            "INSERT INTO danhmuc (Ten, TrangThai) VALUES (?, ?)",
            [$tenDanhMuc, 1]
        );
    }

    // 🔹 Lấy danh mục vừa thêm (ID lớn nhất)
    public static function getLastDM()
    {
        return DB::selectOne("SELECT * FROM danhmuc ORDER BY MaDanhMuc DESC LIMIT 1");
    }

    // 🔹 Kiểm tra danh mục đã tồn tại chưa
    public static function existsByTen($tenDanhMuc)
    {
        $result = DB::selectOne("SELECT COUNT(*) as count FROM danhmuc WHERE Ten = ?", [$tenDanhMuc]);
        return $result && $result->count > 0;
    }

    // 🔹 Lấy toàn bộ danh mục (nếu cần hiển thị)
    public static function getAll()
    {
        return DB::select("SELECT * FROM danhmuc WHERE TrangThai = 1 ORDER BY Ten ASC");
    }
}
