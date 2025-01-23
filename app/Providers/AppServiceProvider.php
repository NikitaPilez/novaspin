<?php

namespace App\Providers;

use App\Contracts\PromoCode\PromoCodeContract;
use App\Services\PromoCode\PromoCodeService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PromoCodeContract::class, PromoCodeService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
