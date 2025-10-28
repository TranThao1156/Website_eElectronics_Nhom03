<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BackOffice_Sp extends Model
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

    // Lấy danh sách tất cả sản phẩm (có thể lọc theo trạng thái hoặc tìm kiếm)
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

            // Thêm slug tạm thời cho từng sản phẩm
            foreach ($result as $product) {
                $product->slug = Str::slug($product->Ten) . '-' . $product->MaSanPham;
            }
            return $result;
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Lỗi khi lấy danh sách sản phẩm: ' . $e->getMessage()
            ];
        }
    }

    // Hiển thị đường link slug
    public function show($slug)
    {
        $id = (int) substr(strrchr($slug, '-'), 1);
        $product = DB::table('sanpham')->where('MaSanPham', $id)->first();

        return view('products.show', compact('product'));
    }
    
    // Xử lý thêm sản phẩm
    public function handleAddProduct(array $data)
    {
        try {
            // Kiểm tra người dùng đăng nhập
            $user = session('user');
            if (!$user) {
                return [
                    'status' => 'error',
                    'message' => 'Bạn chưa đăng nhập. Vui lòng đăng nhập để thêm sản phẩm.'
                ];
            }

            $IDUser = is_array($user) ? $user['IDUser'] : $user->IDUser;

            // Kiểm tra hoặc thêm danh mục
            $danhMuc = DB::table('danhmuc')->where('Ten', $data['MaDanhMuc'])->first();
            $maDanhMuc = $danhMuc ? $danhMuc->MaDanhMuc : DB::table('danhmuc')->insertGetId([
                'Ten' => $data['MaDanhMuc'],
                'TrangThai' => 1
            ]);

            // Kiểm tra hoặc thêm nhà cung cấp
            $ncc = DB::table('nhacungcap')->where('Ten', $data['MaNhaCungCap'])->first();
            $maNCC = $ncc ? $ncc->MaNhaCungCap : DB::table('nhacungcap')->insertGetId([
                'Ten' => $data['MaNhaCungCap'],
                'TrangThai' => 1
            ]);

            // Xử lý ảnh upload
            $imagePaths = [];
            if (isset($data['HinhAnh'])) {
                $files = is_array($data['HinhAnh']) ? $data['HinhAnh'] : [$data['HinhAnh']];
                foreach ($files as $image) {
                    if ($image && $image->isValid()) {
                        $fileName = time() . '_' . $image->getClientOriginalName();
                        $image->move(public_path('img/products'), $fileName);
                        $imagePaths[] = $fileName;
                    }
                }
            }
            // Chuyển mảng đường dẫn ảnh thành chuỗi phân tách bằng dấu ','
            $imagesString = implode(',', $imagePaths);

            // Thêm sản phẩm vào database
            DB::table('sanpham')->insert([
                'Ten' => $data['Ten'],
                'HinhAnh' => $imagesString,
                'IDUser' => $IDUser,
                'SoLuong' => $data['SoLuong'],
                'GiaNhap' => $data['GiaNhap'],
                'GiaSauGiam' => $data['GiaSauGiam'] ?? null,
                'MoTa' => $data['MoTa'] ?? '',
                'MaDanhMuc' => $maDanhMuc,
                'MaNhaCungCap' => $maNCC,
                'Tags' => $data['Tags'] ?? '',
                'NgayCapNhat' => now(),
                'TrangThai' => 1
            ]);

            return [
                'status' => 'success',
                'message' => 'Thêm sản phẩm thành công!'
            ];
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Lỗi khi thêm sản phẩm: ' . $e->getMessage()
            ];
        }
    }
}
