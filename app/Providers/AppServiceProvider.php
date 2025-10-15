<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Service\CaiDatService;
use Illuminate\Support\Facades\Route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(CaiDatService $caiDatService)
    {
        $socialLinks = $caiDatService->getSocialLinks();
        View::share('socialLinks', $socialLinks);
        
    }
   

}
