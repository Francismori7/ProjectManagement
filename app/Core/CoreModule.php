<?php

namespace App\Core;

use App\Contracts\ACL\PermissionRepository;
use App\Contracts\Core\BaseRepository;
use App\Core\ACL\Repositories\EloquentPermissionRepository;
use App\Core\Repositories\EloquentBaseRepository;
use Illuminate\Routing\Router;

class CoreModule extends Module
{
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
