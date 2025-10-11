<?php

namespace App\Http\Controllers;

use App\Service\DanhMucService;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    protected $DanhMucService;

    public function __construct(DanhMucService $danhMucService)
    {
        $this->DanhMucService = $danhMucService;
    }

    // Trang danh sách danh mục
    public function index(Request $request)
    {
        $dsDanhMuc = $this->DanhMucService->getAll();
        return view('backoffice.add_product', compact('dsDanhMuc')
    );
    }
}