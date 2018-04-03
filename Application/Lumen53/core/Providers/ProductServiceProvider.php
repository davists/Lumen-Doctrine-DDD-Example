<?php
namespace Application\Lumen53\Providers;

use Illuminate\Support\ServiceProvider;

class ProductServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Domain\Contracts\Repository\ProductRepositoryContract', 'Infrastructure\Persistence\Doctrine\Repositories\ProductRepository');
        $this->app->bind('Domain\Contracts\Service\ProductServiceContract', 'Domain\Services\ProductService');
    }
}