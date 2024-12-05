<?php

namespace App\Providers;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\Interfaces\ProductRepositoryInteface;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInteface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
