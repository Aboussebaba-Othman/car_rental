<?php

namespace App\Providers;

use App\Repositories\Eloquent\CompanyRepository;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\VehicleRepositoryInterface;
use App\Repositories\Eloquent\VehicleRepository;
use App\Repositories\Interfaces\PromotionRepositoryInterface;
use App\Repositories\Eloquent\PromotionRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(VehicleRepositoryInterface::class, VehicleRepository::class);
        $this->app->bind(PromotionRepositoryInterface::class, PromotionRepository::class);

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}