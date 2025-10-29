<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Models\CaiDat;
class CaiDatController extends Controller
{
    public function boot(CaiDat $caiDat)
    {
        $caidat = $caiDat->getCaiDat();
        $social = $caiDat->getSocialLinks();

        View::share('caidat', $caidat);
        View::share('social', $social);
    }
}