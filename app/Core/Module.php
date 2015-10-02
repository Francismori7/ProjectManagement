<?php

namespace App\Core;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

abstract class Module extends ServiceProvider
{
    /**
     * Register all the bindings on the service container.
     */
    abstract public function registerContainerBindings();

    /**
     * Map all the routes needed by this module.
     *
     * @param Illuminate\Routing\Router $router
     */
    abstract public function map(Router $router);

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {}

    /**
     * Return all the permissions this module needs installed.
     *
     * @return array
     */
    public function getModulePermissions()
    {
        return [];
    }

    /**
     * Register any container services.
     */
    public function register()
    {
        $this->registerContainerBindings();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $router = $this->app->make('Illuminate\Routing\Router');

        $this->map($router);
    }
}
