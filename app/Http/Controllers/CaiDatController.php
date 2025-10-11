<?php
use Illuminate\Support\Facades\View;
use App\Service\CaiDatService;
class AppServiceProvider extends ServiceProvider
{
    public function boot(CaiDatService $caiDatService)
    {
        $caidat = $caiDatService->getCaiDat();
        $social = $caiDatService->getSocialLinks();

        View::share('caidat', $caidat);
        View::share('social', $social);
    }
}