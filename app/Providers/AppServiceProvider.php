<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use App\Models\Store;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
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
        Paginator::useBootstrapFive();
        if (Schema::hasTable('stores'))
        {
            View::share('stores', Store::enabled()->get());
        }
    }
}
