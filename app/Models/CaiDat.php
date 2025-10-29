<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaiDat extends Model
{
    protected $table = 'caidat'; // Tên bảng
    protected $fillable = [
        'TenWebsite', 'MoTa', 'Facebook', 'Twitter', 'Youtube',
        'Linkedin', 'Pinterest', 'Copyright'
    ];

    // Lấy bản ghi đầu tiên
    public static function getThongTin()
    {
        return self::first();
    }

    // Lấy riêng link mạng xã hội
    public static function getSocialLinks()
    {
        return self::select('Facebook', 'Twitter', 'Youtube', 'Linkedin', 'Pinterest')->first();

    }
}
