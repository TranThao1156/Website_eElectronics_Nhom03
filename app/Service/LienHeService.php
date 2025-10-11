<?php
namespace App\Service;
use Illuminate\Support\Facades\DB;

class LienHeService
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
    public function update($id, $data)
    {
        return DB::table('lienhe')->where('MaLienHe', $id)->update($data);
    }

    // Xóa liên hệ
    public function delete($id)
    {
        return DB::table('lienhe')->where('MaLienHe', $id)->delete();
    }
}