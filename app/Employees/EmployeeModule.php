<?php

namespace App\Employees;

use App\Contracts\Projects\InvitationRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Module;
use App\Projects\Repositories\EloquentInvitationRepository;
use App\Projects\Repositories\EloquentProjectRepository;
use App\Projects\Repositories\EloquentTaskRepository;
use Illuminate\Routing\Router;
use App\Contracts\Projects\ProjectRepository;

class EmployeeModule extends Module
{
    /**
     * Register all the bindings on the service container.
     */
    public function registerContainerBindings()
    {
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param  Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['prefix' => 'api/v1', 'as' => 'api.v1.', 'namespace' => 'App\Employees\Controllers\Api\v1'],
            function (Router $router) {
                $router->group(['prefix' => 'employees', 'as' => 'employees.'], function (Router $router) {
                    $router->get('{employee}', ['as' => 'show', 'uses' => 'EmployeeController@show']);
                });
            });
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
     * Bootstrap the module.
     */
    public function bootModule()
    {
    }
}
