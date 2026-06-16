<?php

namespace App\Providers;
use Illuminate\Support\Facades\View;        
use App\Models\MobileBrand;  
use App\Models\LaptopBrand;
use App\Models\LaptopModel;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
{
    View::composer('sell.partials.navbar', function ($view) {
        $view->with('brands', MobileBrand::withCount('models')->get());
        $view->with('laptopBrands', LaptopBrand::withCount('models')->get());
    });
}
}
