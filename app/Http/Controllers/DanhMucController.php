<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMuc;

class DanhMucController extends Controller
{
    public function ajaxAdd(Request $request)
    {
        // Kiểm tra dữ liệu đầu vào
        $request->validate([
            'Ten' => 'required|string|max:100',
        ], [
            'Ten.required' => 'Tên danh mục không được để trống',
            'Ten.max' => 'Tên danh mục tối đa 100 ký tự',
        ]);

        $ten = trim($request->Ten);

        // Kiểm tra trùng tên bằng Eloquent
        $exists = DanhMuc::where('Ten', $ten)->exists();
        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Danh mục đã tồn tại!',
            ], 422);
        }

        // Thêm mới bằng ORM
        $dm = new DanhMuc();
        $dm->Ten = $ten;
        $dm->TrangThai = 1;
        $dm->save();

        // Lấy lại danh mục vừa thêm (vì đã có sẵn $dm)
        return response()->json([
            'success' => true,
            'message' => 'Thêm danh mục thành công!',
            'data' => $dm,
        ]);
    }
}
