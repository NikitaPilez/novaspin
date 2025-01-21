<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\User\JWTAuthContract;
use App\Services\User\JWTAuthService;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(JWTAuthContract::class, JWTAuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
