<?php

namespace App\Providers;

use App\Http\Middleware\CheckUserRole;
// use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register the route middleware
        $this->app->bind('middleware.role', CheckUserRole::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register middleware aliases
        $router = $this->app['router'];
        $router->aliasMiddleware('role', CheckUserRole::class);
    }
}