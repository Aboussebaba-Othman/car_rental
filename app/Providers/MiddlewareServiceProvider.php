<?php

namespace App\Providers;

use App\Http\Middleware\CheckUserRole;

use Illuminate\Support\ServiceProvider;

class MiddlewareServiceProvider extends ServiceProvider
{
  
    public function register(): void
    {
        $this->app->bind('middleware.role', CheckUserRole::class);
    }

    public function boot(): void
    {
        $router = $this->app['router'];
        $router->aliasMiddleware('role', CheckUserRole::class);
    }
}