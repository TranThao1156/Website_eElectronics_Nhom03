<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhaCungCap extends Model
{
     protected $table = 'nhacungcap';
    protected $primaryKey = 'MaNhaCungCap';
    public $timestamps = false;
    protected $fillable = [
        'Ten',
        'Email',
        'SoDienThoai',
        'DiaChi',
        'TrangThai',

    ];
}
