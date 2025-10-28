<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

if (! function_exists('generateUniqueSlug')) {
    /**
     * Tạo slug duy nhất
     *
     * @param string $name Tên sản phẩm
     * @param string $table Tên bảng
     * @param string $slugField Tên cột slug
     * @return string
     */
    function generateUniqueSlug($name, $table = 'sanpham', $slugField = 'slug')
    {
        // Giữ Unicode, thay khoảng trắng bằng '-'
        $slug = str_replace(' ', '-', $name); // Nếu Str::of() lỗi, dùng str_replace
        $originalSlug = $slug;
        $counter = 1;

        // Kiểm tra trùng trong DB
        while (DB::table($table)->where($slugField, $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
