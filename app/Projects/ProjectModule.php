<?php

namespace App\Projects;

use App\Core\Module;
use Illuminate\Routing\Router;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Contracts\Projects\ProjectRepository;
use App\Projects\Repositories\DoctrineProjectRepository;

class ProjectModule extends Module
{
    /**
     * Register all the bindings on the service container.
     *
     * @return void
     */
    public function registerContainerBindings()
    {

        $this->app->bind(ProjectRepository::class, function ($app) {
            return new DoctrineProjectRepository(
                $app['em'],
                new ClassMetadata(User::class));
        });
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param  Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        
    }

    /**
     * Bootstrap the module.
     *
     * @return void
     */
    public function bootModule()
    {

    }
}
