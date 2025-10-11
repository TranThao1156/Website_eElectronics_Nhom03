<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

class SanPhamService
{
    //Thảo - Lấy tất cả sản phẩm
    public function getAll()
    {
        return DB::select('SELECT * FROM sanpham WHERE TrangThai = 1');
    }

    //Thảo - Tìm sản phẩm theo mã để hiển thị lên recently viewed
    public function find($MaSanPham)
    {
        return DB::selectOne("
            SELECT MaSanPham AS id,
                Ten AS Ten,
                SUBSTRING_INDEX(HinhAnh, ',', 1) AS HinhAnh,
                GiaNhap,
                GiaSauGiam,
                MoTa,
                MaDanhMuc
            FROM sanpham
            WHERE MaSanPham = ?
        ", [$MaSanPham]);
    }

    public function getLatestProducts(int $limit = 50)
    {
        return DB::select("
            SELECT MaSanPham AS id,
            Ten AS TenSanPham,
            SUBSTRING_INDEX(HinhAnh, ',', 1) AS HinhAnh,
            GiaSauGiam AS Gia
            FROM sanpham
            ORDER BY MaSanPham DESC
            LIMIT ?
        ", [$limit]);
    }


    public function topseller(int $limit = 3)
    {
        return DB::select("
            SELECT MaSanPham AS id, 
            Ten AS TenSanPham,
            SUBSTRING_INDEX(HinhAnh, ',', 1) AS HinhAnh,
            GiaNhap, GiaSauGiam
            FROM sanpham
            WHERE TrangThai = 1
            ORDER BY MaSanPham DESC
            LIMIT ?
        ", [$limit]);
    }

    public function getTop(int $limit = 3)
    {
        // Kiểm tra xem cột 'NgayCapNhat' có tồn tại không
        $schema = DB::connection()->getSchemaBuilder();
        $table = 'sanpham';
        $hasNgayCapNhat = $schema->hasColumn($table, 'NgayCapNhat');

        $orderBy = $hasNgayCapNhat ? 'NgayCapNhat' : 'MaSanPham';

        return DB::select("
            SELECT MaSanPham,
            Ten,
            SUBSTRING_INDEX(HinhAnh, ',', 1) AS HinhAnh,
            GiaNhap,
            GiaSauGiam,
            NgayCapNhat
            FROM sanpham
            WHERE TrangThai = 1
            ORDER BY $orderBy DESC
            LIMIT ?
        ", [$limit]);
    }
}


    // public function findById(int $id)
    // {
    //     return DB::selectOne("
    //         SELECT MaSanPham AS id,
    //         Ten AS TenSanPham,
    //         SUBSTRING_INDEX(HinhAnh, ',', 1) AS HinhAnh,
    //         GiaSauGiam AS Gia,
    //         MoTa,
    //         ChiTietKyThuat,
    //         DanhMuc
    //         FROM sanpham
    //         WHERE MaSanPham = ?", [$id]);
    // }

    // public function show($id)
    // {
    //     $product = $this->find($id);

    //     if (!$product) {
    //         abort(404, 'Sản phẩm không tồn tại');
    //     }

    //     return view('single-product', compact('product'));
    // }