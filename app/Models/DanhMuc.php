<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;

    // Tên bảng trong database
    protected $table = 'danhmuc';

    // Tên cột khóa chính
    protected $primaryKey = 'MaDanhMuc';

    // Nếu không dùng created_at / updated_at
    public $timestamps = false;

    // Các cột được phép gán dữ liệu hàng loạt
    protected $fillable = [
        'Ten',
        'TrangThai',
    ];

    // (Tùy chọn) ép kiểu cho các trường
    // protected $casts = [
    //     'MaDanhMuc' => 'integer',
    //     'TrangThai' => 'integer',
    // ];
}
