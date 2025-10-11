<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use App\Service\CaiDatService;
class CaiDatController extends Controller
{
    public function boot(CaiDatService $caiDatService)
    {
        $caidat = $caiDatService->getCaiDat();
        $social = $caiDatService->getSocialLinks();

        View::share('caidat', $caidat);
        View::share('social', $social);
    }
}