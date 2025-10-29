<?php

namespace App\Http\Controllers;

use App\Models\LienHe;
use Illuminate\Http\Request;

class LienHeController extends Controller
{
    // Lưu liên hệ mới từ form
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Ten' => 'required|string|max:100',
            'SoDienThoai' => 'required|digits_between:9,11',
            'Email' => 'required|email',
            'TieuDe' => 'nullable|string|max:255',
            'NoiDung' => 'required|string',
        ]);

        // Tạo bản ghi mới
        LienHe::create([
            'Ten' => $validated['Ten'],
            'SoDienThoai' => $validated['SoDienThoai'],
            'Email' => $validated['Email'],
            'TieuDe' => $validated['TieuDe'] ?? null,
            'NoiDung' => $validated['NoiDung'],
            'TrangThai' => 0, // Mặc định chưa xử lý
            'IDUser' => null, // Nếu người dùng đã đăng nhập
        ]);

        return redirect()
            ->route('contact')
            ->with('success', 'Gửi liên hệ thành công!');
    }
}

