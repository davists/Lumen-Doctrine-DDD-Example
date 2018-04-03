<?php
namespace Application\Lumen53\Providers;

use Illuminate\Support\ServiceProvider;

class ProductCategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Domain\Contracts\Repository\ProductCategoryRepositoryContract', 'Infrastructure\Persistence\Doctrine\Repositories\ProductCategoryRepository');
        $this->app->bind('Domain\Contracts\Service\ProductCategoryServiceContract', 'Domain\Services\ProductCategoryService');
    }
}