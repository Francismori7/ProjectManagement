<?php

namespace App\Core;

use App\Contracts\ACL\PermissionRepository;
use App\Contracts\Core\BaseRepository;
use App\Core\ACL\Models\Permission;
use App\Core\ACL\Repositories\DoctrinePermissionRepository;
use App\Core\Models\BaseEntity;
use App\Core\Repositories\DoctrineBaseRepository;
use DebugBar\Bridge\DoctrineCollector;
use DebugBar\DebugBar;
use Doctrine\DBAL\Logging\DebugStack;
use Doctrine\ORM\Mapping\ClassMetadata;
use EntityManager;
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
        $this->app->bind(BaseRepository::class, function ($app) {
            return new DoctrineBaseRepository(
                $app['em'],
                new ClassMetadata(BaseEntity::class)
            );
        });

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

        /** @var DebugBar $debugbar */
        $debugbar = $this->app['debugbar'];
        $debugbar->addCollector(new DoctrineCollector($debugStack));
    }
}
