<?php
namespace App\Service;

use Illuminate\Support\Facades\DB;

class CaiDatService
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