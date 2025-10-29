<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    protected $table = 'sanpham';
    protected $primaryKey = 'MaSanPham';
    public $timestamps = false; // nếu bảng không có created_at / updated_at

    protected $fillable = [
        'Ten',
        'HinhAnh',
        'IDUser',
        'SoLuong',
        'MaNhaCungCap',
        'GiaNhap',
        'GiaSauGiam',
        'MoTa',
        'NgayCapNhat',
        'TrangThai',
        'MaDanhMuc',
        'Tags'
    ];
}
