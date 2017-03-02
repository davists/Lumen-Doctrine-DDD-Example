<?php

namespace Application\Core\Providers;

use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind('Domain\Manager\Contracts\ManagerRepositoryContract', 'Infrastructure\Doctrine\Repositories\Manager\ManagerRepository');

    }
}
