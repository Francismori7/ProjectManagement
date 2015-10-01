<?php

namespace App\Core;

use App\Contracts\Core\BaseRepository;
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
     * Register all the bindings on the service container.
     *
     * @return void
     */
    public function registerContainerBindings()
    {
        $this->app->bind(BaseRepository::class, function ($app) {
            return new DoctrineBaseRepository(
                $app['em'],
                new ClassMetadata(BaseEntity::class)
            );
        });
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
     *
     * @return void
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
