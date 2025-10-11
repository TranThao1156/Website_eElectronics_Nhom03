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

        
    }
