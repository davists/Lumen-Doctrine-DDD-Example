<?php
namespace Application\Lumen53\Providers;

use Illuminate\Support\ServiceProvider;

class CategoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('Domain\Contracts\Repository\CategoryRepositoryContract', 'Infrastructure\Persistence\Doctrine\Repositories\CategoryRepository');
        $this->app->bind('Domain\Contracts\Service\CategoryServiceContract', 'Domain\Services\CategoryService');
    }
}