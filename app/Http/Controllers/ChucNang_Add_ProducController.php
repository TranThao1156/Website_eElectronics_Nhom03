<?php

namespace App\Http\Controllers;

    use App\Service\ChucNang_Add_ProducService;
    use Illuminate\Http\Request;

    class ChucNang_Add_ProducController extends Controller
    {
        protected $ProducService;

        public function __construct(ChucNang_Add_ProducService $producService)
        {
            $this->ProducService = $producService;
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