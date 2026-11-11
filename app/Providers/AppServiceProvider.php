<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Product;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer('layouts.Admin', function ($view) {

            $outOfStockProducts = Product::where('stock', 0)->get();

            $view->with('outOfStockProducts', $outOfStockProducts);
        });
    }
}
