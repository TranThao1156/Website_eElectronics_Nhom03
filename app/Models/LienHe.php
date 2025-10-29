<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class LienHe extends Model
{
    // Lấy tất cả liên hệ
    public function getAll()
    {
        return DB::table('lienhe')->get();
    }

    // Lấy liên hệ theo ID
    public function find($id)
    {
        return DB::table('lienhe')->where('MaLienHe', $id)->first();
    }

    // Thêm liên hệ mới
    public function create($data)
    {
        return DB::table('lienhe')->insert($data);
    }

    // Cập nhật liên hệ
    public function updateLH($id, $data)
    {
        return DB::table('lienhe')->where('MaLienHe', $id)->update($data);
    }

    // Xóa liên hệ
    public function deleteLH($id)
    {
        return DB::table('lienhe')->where('MaLienHe', $id)->delete();
    }
}
