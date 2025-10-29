<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMuc;

class DanhMucController extends Controller
{
    public function ajaxAdd(Request $request)
    {
        $request->validate([
            'Ten' => 'required|string|max:100',
        ], [
            'Ten.required' => 'Tên danh mục không được để trống',
            'Ten.max' => 'Tên danh mục tối đa 100 ký tự',
        ]);

        $ten = trim($request->Ten);

        // 🔹 Kiểm tra trùng tên
        if (DanhMuc::existsByTen($ten)) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục đã tồn tại!',
            ], 422);
        }

        // 🔹 Thêm mới
        DanhMuc::insertRaw($ten);
        $dm = DanhMuc::getLastDM();

        return response()->json([
            'success' => true,
            'message' => 'Thêm danh mục thành công!',
            'data' => $dm,
        ]);
    }
}
