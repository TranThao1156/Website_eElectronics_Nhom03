<?php

namespace App\Http\Controllers;

use App\Service\BackOffice_SpService;
use Illuminate\Http\Request;

class BackOffice_SpController extends Controller
{
    protected $ProducService;

    public function __construct(BackOffice_SpService $producService)
    {
        $this->ProducService = $producService;
    }

    //Lấy danh sách sản phẩm
    public function listProducts()
    {
        $dsSanPham = $this->ProducService->getAllProducts();
        return view('backoffice.list_products', compact('dsSanPham'));
    }

    // Trang thêm sản phẩm
    public function index(Request $request)
    {
        $dsDanhMuc = $this->ProducService->getAll();
        $dsNhaCungCap = $this->ProducService->getNhaCungCap();
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

        $result = $this->ProducService->handleAddProduct($request->all());

        return redirect()->back()->with($result['status'], $result['message']);
    }
}
