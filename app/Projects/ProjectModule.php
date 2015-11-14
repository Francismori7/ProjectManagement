<?php

namespace App\Projects;

use App\Contracts\Projects\InvitationRepository;
use App\Core\Module;
use App\Projects\Repositories\EloquentInvitationRepository;
use App\Projects\Repositories\EloquentProjectRepository;
use Illuminate\Routing\Router;
use App\Contracts\Projects\ProjectRepository;

class ProjectModule extends Module
{
    /**
     * Register all the bindings on the service container.
     */
    public function registerContainerBindings()
    {
        $this->app->bind(ProjectRepository::class, EloquentProjectRepository::class);
        $this->app->bind(InvitationRepository::class, EloquentInvitationRepository::class);
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
     * Return all the permissions this module needs installed.
     *
     * @return array
     */
    public function getModulePermissions()
    {
        return [
            'projects.project.create' => 'Create projects',
            'projects.project.update' => 'Update projects',
            'projects.project.destroy' => 'Remove projects',
            'projects.project.invite' => 'Invite users',
            'projects.project.promote_user' => 'Promote users',
        ];
    }

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {
    }
}
