<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

class CaiDat extends Model
{
    // Lấy bản ghi đầu tiên trong bảng 'caidat'
    public function getCaiDat()
    {
        return DB::table('caidat')->first();
    }

    // Lấy riêng các link mạng xã hội
    public function getSocialLinks()
    {   
        return DB::table('caidat')
            ->select('Facebook', 'Youtube', 'Linkedin')
            ->first();
    }
}
