<?php

namespace App\Http\Controllers;

class DanhMucController extends Controller
{
    public function index()
    {
        $ds = DanhMuc::all();
        return view('danhmuc.index', compact('ds'));
    }

    public function store(Request $request)
    {
        DanhMuc::create([
            'Ten' => $request->Ten,
            'TrangThai' => $request->TrangThai,
        ]);

        return redirect()->back()->with('success', 'Thêm danh mục thành công');
    }
}
