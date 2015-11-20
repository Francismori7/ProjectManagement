<?php

namespace App\Core;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

abstract class Module extends ServiceProvider
{
    /**
     * The event handler mappings for the application.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [];

    /**
     * Binds the route model bindings for the module.
     *
     * @param Router $router
     */
    public function bindModuleRouteBindings(Router $router)
    {
    }

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
     * Boots up the events dispatcher to listen for events.
     *
     * @param Dispatcher $events
     */
    public function bootEventDispatcher(Dispatcher $events)
    {
        foreach ($this->listen as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }

        foreach ($this->subscribe as $subscriber) {
            $events->subscribe($subscriber);
        }
    }

    /**
     * Register any container services.
     */
    public function register()
    {
        $this->registerContainerBindings();
    }

    /**
     * Register all the bindings on the service container.
     */
    abstract public function registerContainerBindings();

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $router = $this->app->make(Router::class);

        $this->bindModuleRouteBindings($router);
        $this->map($router);

        $this->bootModule();
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param  Router $router
     * @return void
     */
    abstract public function map(Router $router);

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {
    }

    /**
     * Get the events and handlers.
     *
     * @return array
     */
    public function listens()
    {
        return $this->listen;
    }
}
