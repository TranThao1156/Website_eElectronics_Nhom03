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

    public function handleAddProduct(array $data)
    {
    try {
        //Kiểm tra người dùng đăng nhập ===
        // $user = Auth::user();
        // if (!$user) {
        //     return [
        //         'status' => 'error',
        //         'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập để thêm sản phẩm.'
        //     ];
        // }
        // $IDUser = $user->id; 

        // Kiểm tra danh mục
        $sqlCheckDanhMuc = "SELECT MaDanhMuc FROM danhmuc WHERE Ten = ? LIMIT 1";
        $danhMuc = DB::selectOne($sqlCheckDanhMuc, [$data['MaDanhMuc']]);

        if ($danhMuc) {
            $maDanhMuc = $danhMuc->MaDanhMuc;
        } else {
            $sqlInsertDanhMuc = "INSERT INTO danhmuc (Ten, TrangThai) VALUES (?, 1)";
            DB::insert($sqlInsertDanhMuc, [$data['MaDanhMuc']]);
            $maDanhMuc = DB::getPdo()->lastInsertId();
        }

        // Kiểm tra nhà cung cấp
        $sqlCheckNCC = "SELECT MaNhaCungCap FROM nhacungcap WHERE Ten = ? LIMIT 1";
        $ncc = DB::selectOne($sqlCheckNCC, [$data['MaNhaCungCap']]);

        if ($ncc) {
            $maNCC = $ncc->MaNhaCungCap;
        } else {
            $sqlInsertNCC = "INSERT INTO nhacungcap (Ten, TrangThai) VALUES (?, 1)";
            DB::insert($sqlInsertNCC, [$data['MaNhaCungCap']]);
            $maNCC = DB::getPdo()->lastInsertId();
        }

        //Xử lý ảnh
        $imagePaths = [];
        if (isset($data['HinhAnh']) && is_array($data['HinhAnh'])) {
            foreach ($data['HinhAnh'] as $img) {
                $path = $img->store('uploads/sanpham', 'public');
                $imagePaths[] = $path;
            }
        }

        $imagesString = implode(',', $imagePaths);

        // Thêm sản phẩm ===
        $sqlInsertSP = "
            INSERT INTO sanpham 
            (Ten, HinhAnh, IDUser, SoLuong, GiaNhap, GiaSauGiam, MoTa, MaDanhMuc, MaNhaCungCap, Tags, NgayCapNhat, TrangThai)
            VALUES (?, ?, 1, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)
        ";

        DB::insert($sqlInsertSP, [
            $data['Ten'],
            $imagesString,
            // $IDUser,          // người nhập
            $data['SoLuong'],
            $data['GiaNhap'],
            $data['GiaSauGiam'] ?? null,
            $data['MoTa'],
            $maDanhMuc,
            $maNCC,
            $data['Tags'] ?? ''
        ]);
        
        return [
            'status' => 'success',
            'message' => 'Thêm sản phẩm thành công!',
        ];
    } catch (\Exception $e) {
        return [
            'status' => 'error',
            'message' => 'Lỗi SQL: ' . $e->getMessage(),
        ];
    }
}

}