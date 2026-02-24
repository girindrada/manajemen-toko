<?php

namespace App\Providers;

use App\Repositories\AuthRepository;
use App\Repositories\StoreRepository;
use App\Repositories\Contracts\AuthRepositoryInterface;
use App\Repositories\Contracts\StoreRepositoryInterface;
use App\Repositories\Contracts\StoreUserRepositoryInterface;
use App\Repositories\StoreUserRepository;
use Illuminate\Support\ServiceProvider;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
