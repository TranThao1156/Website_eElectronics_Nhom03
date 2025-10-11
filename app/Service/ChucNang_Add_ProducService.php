<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

class ChucNang_Add_ProducService
{
    //Thảo - Lấy tất cả danh mục
    public function getAll()
    {
        return DB::select("SELECT * FROM danhmuc WHERE TrangThai = 1");
    }
    //Khanh - Lấy tất cả nhà cung cấp
    public function getNhaCungCap()
    {
        return DB::select("SELECT * FROM nhacungcap WHERE TrangThai = 1");
    }
}