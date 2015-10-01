<?php

namespace App\Core;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

abstract class Module extends ServiceProvider
{
    /**
     * Register all the bindings on the service container.
     *
     * @return void
     */
    abstract function registerContainerBindings();

    /**
     * Map all the routes needed by this module.
     *
     * @param  Router $router
     * @return void
     */
    abstract function map(Router $router);

    /**
     * Bootstrap the module.
     *
     * @return void
     */
    abstract function bootModule();

    /**
     * Register any container services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerContainerBindings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);

        $this->map($router);

        $this->bootModule();
    }
}
