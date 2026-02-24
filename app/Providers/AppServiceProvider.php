<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\StoreRepository;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\StoreRepositoryInterface;
use App\Repositories\Contracts\StoreUserRepositoryInterface;
use App\Repositories\StoreUserRepository;
use Illuminate\Support\ServiceProvider;
use App\Policies\AdminStorePolicy;
use App\Repositories\CashierRepository;
use App\Repositories\Contracts\CashierRepositoryInterface;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\SaleRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Repositories\SaleRepository;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(StoreRepositoryInterface::class, StoreRepository::class); 
        $this->app->bind(StoreUserRepositoryInterface::class, StoreUserRepository::class);
        $this->app->bind(CashierRepositoryInterface::class, CashierRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(SaleRepositoryInterface::class, SaleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Admin hanya boleh mengelola data yang ada di storeId nya 
        Gate::policy(AdminStorePolicy::class, AdminStorePolicy::class);
    }
}
