<?php

namespace App\Core;

use EntityManager;
use Illuminate\Routing\Router;
use Doctrine\DBAL\Logging\DebugStack;
use DebugBar\Bridge\DoctrineCollector;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Core\ACL\Models\Permission;
use App\Contracts\ACL\PermissionRepository;
use App\Core\ACL\Repositories\DoctrinePermissionRepository;

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
        $this->app->bind(PermissionRepository::class, function ($app) {
            return new DoctrinePermissionRepository(
                $app['em'],
                new ClassMetadata(Permission::class)
            );
        });

        $modules = $this->getModules();

        foreach ($modules as $module) {
            $this->app->register($module);

            $this->registerModulePermissions($module);
        }

        $this->app->instance('permissions', $this->permissions);
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
     * Return all the enabled modules.
     *
     * @return array
     */
    protected function getModules()
    {
        return require __DIR__.'/../modules.php';
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param  Illuminate\Routing\Router
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => 'App\Core\Controllers'], function ($router) {
            $router->get('/', ['as' => 'home', 'uses' => 'IndexController@index']);
            $router->get('/create', ['as' => 'create', 'uses' => 'IndexController@create']);
        });
    }

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {
        $debugStack = new DebugStack();
        EntityManager::getConnection()
                     ->getConfiguration()
                     ->setSQLLogger($debugStack);

        $this->app['debugbar']->addCollector(new DoctrineCollector($debugStack));
    }
}
