<?php

namespace App\Projects;

use App\Auth\Models\User;
use App\Contracts\Projects\InvitationRepository;
use App\Core\Module;
use App\Projects\Repositories\DoctrineInvitationRepository;
use Illuminate\Routing\Router;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Contracts\Projects\ProjectRepository;
use App\Projects\Repositories\DoctrineProjectRepository;

class ProjectModule extends Module
{
    /**
     * Register all the bindings on the service container.
     */
    public function registerContainerBindings()
    {
        $this->app->bind(ProjectRepository::class, function ($app) {
            return new DoctrineProjectRepository(
                $app['em'],
                new ClassMetadata(Project::class));
        });
        $this->app->bind(InvitationRepository::class, function ($app) {
            return new DoctrineInvitationRepository(
                $app['em'],
                new ClassMetadata(Invitation::class));
        });
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param  Router $router
     * @return void
     */
    public function map(Router $router)
    {
    }

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {
    }
}
