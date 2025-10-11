<?php

namespace App\Http\Controllers;
use App\Service\LienHeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LienHeController extends Controller
{
    protected $lienHeService;
    public function __construct(LienHeService $lienHe)
    {
        $this->lienHeService = $lienHe;
    }
    public function index() {
        $dsLienHe = $this->lienHeService->getAll();
        return view('user.contact', ['contact' => $dsLienHe]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'Ten' => 'required|string|max:100',
            'SoDienThoai' => 'required|digits:10',
            'Email' => 'required|email',
            'NoiDung' => 'required|string'
        ]);
        $this->lienHeService->create([
            'Ten' => $request->Ten,
            'SoDienThoai' => $request->SoDienThoai,
            'Email' => $request->Email,
            'TieuDe' => $request->TieuDe,
            'NoiDung' => $request->NoiDung,
            'TrangThai' => 0,
            'IDUser' => null
        ]);
        return redirect()->route('contact')->with('success', 'Gửi liên hệ thành công!');
    }
}
