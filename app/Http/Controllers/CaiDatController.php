<?php

namespace App\Http\Controllers;

use App\Models\CaiDat;
use Illuminate\Support\Facades\View;

class CaiDatController extends Controller
{
    // Hàm này bạn có thể gọi trong AppServiceProvider để chia sẻ toàn cục
    public static function boot()
    {
        $caidat = CaiDat::getThongTin();
        $socialLinks = CaiDat::getSocialLinks();

        View::share('caidat', $caidat);
        View::share('socialLinks', $socialLinks);
    }
}
