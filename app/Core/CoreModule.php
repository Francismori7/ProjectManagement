<?php

namespace App\Core;

use App\Contracts\ACL\PermissionRepository;
use App\Contracts\Core\BaseRepository;
use App\Core\ACL\Repositories\EloquentPermissionRepository;
use App\Core\Repositories\EloquentBaseRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use Log;

class CoreModule extends Module
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
     * All the registered permissions.
     *
     * @var array
     */
    protected $permissions = [];

    /**
     * Register all the bindings on the service container.
     */
    public function registerContainerBindings()
    {
        $this->app->bind(BaseRepository::class, EloquentBaseRepository::class);
        $this->app->bind(PermissionRepository::class, EloquentPermissionRepository::class);

        $modules = $this->getModules();

        foreach ($modules as $module) {
            $this->app->register($module);

            $this->bootEventDispatcher(app()->make(Dispatcher::class));
            $this->registerModulePermissions($module);
        }

        $this->app->instance('permissions', $this->permissions);
    }

    /**
     * Return all the enabled modules.
     *
     * @return array
     */
    protected function getModules()
    {
        return require __DIR__ . '/../modules.php';
    }

    /**
     * Boots up the events dispatcher to listen for events.
     *
     * @param Dispatcher $events
     */
    public function bootEventDispatcher(Dispatcher $events)
    {
        parent::bootEventDispatcher($events);

        /*
         * We are logging all queries to the log if we are using APP_DEBUG.
         *
         * Since this is mostly an API, we don't have access to Debugbar features
         * where we could figure out N+1 queries, we'll be using the logs for
         * each query.
         */
        if (env('APP_DEBUG', false)) {
            $events->listen('illuminate.query', function ($query, $bindings, $time, $connectionName) {
                Log::info("[$connectionName@$time] $query (" . implode(', ', $bindings) . ")");
                return false;
            });
        }
    }

    /**
     * Register a module's permissions.
     *
     * @param string $modulename
     */
    private function registerModulePermissions($modulename)
    {
        $key = str_replace('module', '', mb_strtolower($modulename));

        $module = $this->app->resolveProviderClass($modulename);

        $this->permissions = array_merge($module->getModulePermissions(), $this->permissions);
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->group(['as' => 'core.', 'namespace' => 'App\Core\Controllers'], function (Router $router) {
            $router->get('/', ['as' => 'home', 'uses' => 'IndexController@angular']);
        });
    }

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {
    }
}
