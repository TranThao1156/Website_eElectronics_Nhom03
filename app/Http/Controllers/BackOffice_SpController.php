<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\BackOffice_Sp;
use Illuminate\Http\Request;

class BackOffice_SpController extends Controller
{
    protected $SpService;

    public function __construct(BackOffice_Sp $spService)
    {
        $this->SpService = $spService;
    }

    //Lấy danh sách sản phẩm
    public function listProducts()
    {

        $dsSanPham = $this->SpService->getAllProducts();
        foreach ($dsSanPham as $product) {
            $product->slug = Str::slug($product->Ten) . '-' . $product->MaSanPham;
        }
        return view('backoffice.listproduct', compact('dsSanPham'));
    }
    // rang thêm sản phẩm
    public function index(Request $request)
    {
        $dsDanhMuc = $this->SpService->getAll();
        $dsNhaCungCap = $this->SpService->getNhaCungCap();
        return view('backoffice.add_product', compact('dsDanhMuc', 'dsNhaCungCap'));
    }

    // Xử lý submit form thêm sản phẩm
    public function store(Request $request)
    {
        $request->validate([
            'Ten' => 'required|string|max:255',
            'MaDanhMuc' => 'required|string|max:255',
            'MaNhaCungCap' => 'required|string|max:255',
            'GiaNhap' => 'required|numeric|min:1000',
            'SoLuong' => 'required|integer|min:1',
        ]);

        $data = $request->all();
        $data['HinhAnh'] = $request->file('HinhAnh');

        //Code để thêm mô tả có ckeditor vào csdl
        $data['MoTa'] = $request->input('MoTa');

        $result = $this->SpService->handleAddProduct($data);

        return redirect()->back()->with($result['status'], $result['message']);
    }
}
