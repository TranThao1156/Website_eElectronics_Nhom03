<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

class SanPhamService
{
    public function getAll()
    {
        return DB::select('SELECT * FROM sanpham WHERE TrangThai = 1');
    }

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


    public function create($data)
    {
        $columns = implode(',', array_keys($data));
        //Khôi(chuyển sang SQL thuần 10/10)
        //$data ở đây là mảng dữ liệu của một sản phẩm vd: ['Ten' => 'Laptop', 'Gia' => 1000,...]
        //array_keys là lấy tất cả các tên cột trong bảng
        //implode là nối các phần tử trong mảng thành một chuỗi, phần tử cách nhau bởi dấu phẩy để giống với cú pháp SQL
        //Ví dụ: 'Ten,Gia,...'
        $placeholders = implode(',', array_fill(0, count($data), '?'));
        //array_fill(0, count($data), '?') tạo ra một mảng với số phần tử bằng số cột trong bảng và mỗi phần tử là dấu '?'
        //giống nhu với câu lệnh SQL INSERT INTO sanpham (Ten, Gia,...) VALUES (ip15, 1000, ...)
        $values = array_values($data);

        return DB::insert("INSERT INTO sanpham ($columns) VALUES ($placeholders)", $values);
        //$columns là các cột trong bảng
        //$placeholders là các dữ liệu theo từng cột($columns)
    }

    public function update($id, $data)
    {

        $fields = implode(', ', array_map(fn($col) => "$col = ?", array_keys($data)));

        $values = array_values($data);
        $values[] = $id;

        return DB::update("UPDATE sanpham SET $fields WHERE MaSanPham = ?", $values);
        //Khôi(chuyển sang SQL thuần)
        //array_map(fn($col) => "$col = ?", array_keys($data)) tạo ra một mảng với mỗi phần tử có dạng "TênCột = ?"
        //giống như câu lệnh SQL UPDATE sanpham SET Ten = ?, Gia = ?
        //$fn($col) => "$col = ?" là biến đại diện cho tên cột trong bảng
        //$values là mảng giá trị tương ứng với các cột trong bảng
        //$values[] = $id thêm id vào cuối mảng giá trị để sử dụng trong câu lệnh WHERE
    }

    public function delete($id)
    {
        return DB::delete('DELETE FROM sanpham WHERE MaSanPham = ?', [$id]);
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

    public function findById(int $id)
    {
        return DB::selectOne("
            SELECT MaSanPham AS id,
            Ten AS TenSanPham,
            SUBSTRING_INDEX(HinhAnh, ',', 1) AS HinhAnh,
            GiaSauGiam AS Gia,
            MoTa,
            ChiTietKyThuat,
            DanhMuc
            FROM sanpham
            WHERE MaSanPham = ?", [$id]);
    }

    public function show($id)
    {
        $product = $this->findById($id);

        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại');
        }

        return view('single-product', compact('product'));
    }

    public function topseller(int $limit = 0)
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