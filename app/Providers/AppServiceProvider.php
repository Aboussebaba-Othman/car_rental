<?php

namespace App\Providers;

use App\Repositories\Eloquent\VehicleRepository;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Eloquent\CompanyRepository;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Services\Search\SearchService;
use App\Services\Search\SearchStrategyFactory;
use App\Services\MoroccanCitiesService;
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

       

        $this->app->singleton(MoroccanCitiesService::class, function ($app) {
            return new MoroccanCitiesService();
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
