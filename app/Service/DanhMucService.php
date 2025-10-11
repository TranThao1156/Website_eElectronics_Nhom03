<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

class DanhMucService
{
    //Thảo - Lấy tất cả danh mục
    public function getAll()
    {
        return DB::select('SELECT Ten FROM danhmuc WHERE TrangThai = 1');
    }
}