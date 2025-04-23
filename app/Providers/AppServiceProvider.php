<?php

namespace App\Providers;

use App\Repositories\Eloquent\VehicleRepository;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Eloquent\CompanyRepository;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Services\Search\SearchService;
use App\Services\Search\SearchStrategyFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register repositories
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);

        // Register search service
        $this->app->singleton(SearchService::class, function ($app) {
            return new SearchService();
        });
        
        // Register search strategy factory
        $this->app->singleton(SearchStrategyFactory::class, function ($app) {
            return new SearchStrategyFactory(
                $app->make('App\Repositories\Interfaces\VehicleRepositoryInterface')
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
