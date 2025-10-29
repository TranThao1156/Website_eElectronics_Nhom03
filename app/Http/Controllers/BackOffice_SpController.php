<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BackOffice_SpController extends Controller
{
    protected $SanPham;

    public function __construct(SanPham $products)
    {
        $this->SanPham = $products;
    }

    // Lấy tất cả danh mục (active)
    protected function getAllCategories()
    {
        return DB::table('danhmuc')->where('TrangThai', 1)->get();
    }

    // Lấy tất cả nhà cung cấp (active)
    protected function getAllSuppliers()
    {
        return DB::table('nhacungcap')->where('TrangThai', 1)->get();
    }

    // Trang danh sách sản phẩm (backoffice)
    public function listProducts()
    {
        $dsSanPham = $this->SanPham
            ->select(
                'MaSanPham',
                'Ten',
                'HinhAnh',
                'GiaNhap',
                'GiaSauGiam',
                'SoLuong',
                'NgayCapNhat',
                'TrangThai'
            )
            ->orderByDesc('NgayCapNhat')
            ->get()
            ->map(function ($p) {
                // Lấy hình đầu tiên nếu có nhiều hình cách nhau bởi dấu phẩy
                $p->HinhAnh = isset($p->HinhAnh) ? explode(',', $p->HinhAnh)[0] : null;
                $p->slug = Str::slug($p->Ten) . '-' . $p->MaSanPham;
                return $p;
            });

        return view('backoffice.listproduct', compact('dsSanPham'));
    }

    // Trang thêm sản phẩm (form)
    public function index()
    {
        $dsDanhMuc = $this->getAllCategories();
        $dsNhaCungCap = $this->getAllSuppliers();
        return view('backoffice.add_product', compact('dsDanhMuc', 'dsNhaCungCap'));
    }

    // Xử lý thêm sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'Ten' => 'required|string|max:255',
            'MaDanhMuc' => 'required|integer|exists:danhmuc,MaDanhMuc',
            'MaNhaCungCap' => 'required|integer|exists:nhacungcap,MaNhaCungCap',
            'GiaNhap' => 'required|numeric|min:1000',
            'SoLuong' => 'required|integer|min:1',
        ]);

        try {
            $user = session('user');
            if (!$user) {
                return redirect()->back()->with('error', 'Bạn chưa đăng nhập!');
            }

            $IDUser = is_array($user) ? $user['IDUser'] : $user->IDUser;

            // Xử lý ảnh upload
            $imagePaths = [];
            if ($request->hasFile('HinhAnh')) {
                $files = is_array($request->file('HinhAnh')) ? $request->file('HinhAnh') : [$request->file('HinhAnh')];
                foreach ($files as $image) {
                    if ($image && $image->isValid()) {
                        $fileName = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                        $image->move(public_path('img/products'), $fileName);
                        $imagePaths[] = $fileName;
                    }
                }
            }
            $imagesString = implode(',', $imagePaths);

            // Tạo sản phẩm bằng Eloquent
            $this->SanPham->create([
                'Ten' => $request->Ten,
                'HinhAnh' => $imagesString,
                'IDUser' => $IDUser,
                'SoLuong' => $request->SoLuong,
                'GiaNhap' => $request->GiaNhap,
                'GiaSauGiam' => $request->GiaSauGiam ?? null,
                'MoTa' => $request->input('MoTa') ?? '',
                'MaDanhMuc' => $request->MaDanhMuc,
                'MaNhaCungCap' => $request->MaNhaCungCap,
                'Tags' => $request->Tags ?? '',
                'NgayCapNhat' => now(),
                'TrangThai' => 1
            ]);

            return redirect()->back()->with('success', 'Thêm sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi thêm sản phẩm: ' . $e->getMessage());
        }
    }

    // Xem chi tiết sản phẩm theo slug
    public function show($slug)
    {
        // Lấy id phía sau dấu '-' cuối cùng trong slug
        $idPart = strrchr($slug, '-');
        $id = $idPart ? (int) substr($idPart, 1) : null;

        if (!$id) {
            return abort(404);
        }

        $product = $this->SanPham->find($id);

        if (!$product) {
            return abort(404);
        }

        return view('products.show', compact('product'));
    }
}
