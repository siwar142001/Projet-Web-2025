<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\IsAdmin;

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
        // ✅ Enregistre le middleware manuellement
        Route::aliasMiddleware('is_admin', IsAdmin::class);
    }
}
