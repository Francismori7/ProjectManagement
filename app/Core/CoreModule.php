<?php

namespace App\Core;

use DebugBar\DebugBar;
use EntityManager;
use App\Core\Module;
use Illuminate\Routing\Router;
use Doctrine\DBAL\Logging\DebugStack;
use DebugBar\Bridge\DoctrineCollector;

class CoreModule extends Module
{
    /**
     * Register all the bindings on the service container.
     *
     * @return void
     */
    public function registerContainerBindings()
    {
        
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param Router $router
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => 'App\Core\Controllers'], function(Router $router) {
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
