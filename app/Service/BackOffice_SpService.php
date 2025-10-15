<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BackOffice_SpService
{
    // Lấy tất cả danh mục (active)
    public function getAll()
    {
        return DB::select("SELECT * FROM danhmuc WHERE TrangThai = 1");
    }

    // Lấy tất cả nhà cung cấp (active)
    public function getNhaCungCap()
    {
        return DB::select("SELECT * FROM nhacungcap WHERE TrangThai = 1");
    }

    // Xử lý thêm sản phẩm
    public function handleAddProduct(array $data)
    {
        try {
            // ✅ 1. Kiểm tra người dùng đăng nhập
            $user = Auth::user();
            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập để thêm sản phẩm.'
                ];
            }
            $IDUser = $user->id;

            // ✅ 2. Kiểm tra hoặc thêm danh mục
            $sqlCheckDanhMuc = "SELECT MaDanhMuc FROM danhmuc WHERE Ten = ? LIMIT 1";
            $danhMuc = DB::selectOne($sqlCheckDanhMuc, [$data['MaDanhMuc']]);

            if ($danhMuc) {
                $maDanhMuc = $danhMuc->MaDanhMuc;
            } else {
                DB::insert("INSERT INTO danhmuc (Ten, TrangThai) VALUES (?, 1)", [$data['MaDanhMuc']]);
                $maDanhMuc = DB::getPdo()->lastInsertId();
            }

            // ✅ 3. Kiểm tra hoặc thêm nhà cung cấp
            $sqlCheckNCC = "SELECT MaNhaCungCap FROM nhacungcap WHERE Ten = ? LIMIT 1";
            $ncc = DB::selectOne($sqlCheckNCC, [$data['MaNhaCungCap']]);

            if ($ncc) {
                $maNCC = $ncc->MaNhaCungCap;
            } else {
                DB::insert("INSERT INTO nhacungcap (Ten, TrangThai) VALUES (?, 1)", [$data['MaNhaCungCap']]);
                $maNCC = DB::getPdo()->lastInsertId();
            }

            // ✅ 4. Xử lý ảnh upload
            $imagePaths = [];
            if (isset($data['HinhAnh']) && is_array($data['HinhAnh'])) {
                foreach ($data['HinhAnh'] as $image) {
                    if ($image->isValid()) {
                        $fileName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('img/products'), $fileName);
                        $imagePaths[] = 'img/products/' . $fileName;
                    }
                }
            }

            $imagesString = implode(',', $imagePaths);

            // ✅ 5. Thêm sản phẩm vào database
            $sqlInsertSP = "
                INSERT INTO sanpham 
                (Ten, HinhAnh, IDUser, SoLuong, GiaNhap, GiaSauGiam, MoTa, MaDanhMuc, MaNhaCungCap, Tags, NgayCapNhat, TrangThai)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1)
            ";

            DB::insert($sqlInsertSP, [
                $data['Ten'],
                $imagesString,
                $IDUser,
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
                'message' => '✅ Thêm sản phẩm thành công!'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => '❌ Lỗi: ' . $e->getMessage()
            ];
        }
    }

        // ✅ Lấy danh sách tất cả sản phẩm (có thể lọc theo trạng thái hoặc tìm kiếm)
    public function getAllProducts($onlyActive = true)
    {
        //Lấy danh sách sản phẩm
        try {
            $query = "
                SELECT 
                    MaSanPham, 
                    Ten, 
                    SUBSTRING_INDEX(HinhAnh, ',', 1) as HinhAnh,
                    IDUser, 
                    SoLuong, 
                    MaNhaCungCap, 
                    GiaNhap, 
                    GiaSauGiam, 
                    MoTa, 
                    NgayCapNhat, 
                    TrangThai, 
                    MaDanhMuc, 
                    Tags
                FROM sanpham
            ";

            if ($onlyActive) {
                $query .= " WHERE TrangThai = 1";
            }

            $query .= " ORDER BY NgayCapNhat DESC";

            $result = DB::select($query);

            return $result;
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Lỗi khi lấy danh sách sản phẩm: ' . $e->getMessage()
            ];
        }
    }

}
