<?php

namespace App\Projects;

use App\Contracts\Projects\InvitationRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Module;
use App\Projects\Repositories\EloquentInvitationRepository;
use App\Projects\Repositories\EloquentProjectRepository;
use App\Projects\Repositories\EloquentTaskRepository;
use Illuminate\Routing\Router;
use App\Contracts\Projects\ProjectRepository;

class ProjectModule extends Module
{
    /**
     * Register all the bindings on the service container.
     */
    public function registerContainerBindings()
    {
        $this->app->bind(InvitationRepository::class, EloquentInvitationRepository::class);
        $this->app->bind(ProjectRepository::class, EloquentProjectRepository::class);
        $this->app->bind(TaskRepository::class, EloquentTaskRepository::class);
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param  Router $router
     * @return void
     */
    public function map(Router $router)
    {
        /*
         * No need for 'as' => 'api.v1.' here because resource does it automatically.
         */
        $router->group(['prefix' => 'api/v1', 'as' => 'api.v1.', 'namespace' => 'App\Projects\Controllers\Api\v1'],
            function (Router $router) {
                $router->group(['prefix' => 'projects', 'as' => 'projects.'], function (Router $router) {
                    $router->get('/', ['as' => 'index', 'uses' => 'ProjectController@index']);
                    $router->get('{id}', ['as' => 'show', 'uses' => 'ProjectController@show']);
                    $router->post('/', ['as' => 'store', 'uses' => 'ProjectController@store']);
                    $router->delete('{id}', ['as' => 'destroy', 'uses' => 'ProjectController@destroy']);
                    $router->patch('{id}/restore', ['as' => 'restore', 'uses' => 'ProjectController@restore']);

                    $router->group(['prefix' =>'{id}/users', 'as' => 'users.'], function (Router $router) {
                        $router->get('users', ['as' => 'index', 'uses' => 'ProjectUserController@index']);
                        $router->patch('users/promote', ['as' => 'promote', 'uses' => 'ProjectUserController@promote']);
                        $router->patch('users/demote', ['as' => 'demote', 'uses' => 'ProjectUserController@demote']);
                    });

                    $router->get('{id}/tasks', ['as' => 'tasks.index', 'uses' => 'ProjectTaskController@index']);
//                    $router->get('{id}/comments', ['as' => 'comments', 'uses' => 'ProjectController@comments']);
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
        return [
            'projects.project.create' => 'Create projects',
            'projects.project.update' => 'Update projects',
            'projects.project.destroy' => 'Remove projects',
            'projects.project.restore' => 'Restore projects',
            'projects.project.invite' => 'Invite users',
            'projects.project.promote_user' => 'Promote users',
            'projects.project.demote_user' => 'Demote users',
        ];
    }

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {
    }
}
