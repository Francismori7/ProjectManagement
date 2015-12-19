<?php

namespace App\Projects;

use App\Contracts\Projects\InvitationRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Module;
use App\Projects\Events\EmailWasInvitedToProject;
use App\Projects\Events\UserWasAddedToProject;
use App\Projects\Listeners\SendInvitationEmail;
use App\Projects\Listeners\SendUserAddedToProjectEmail;
use App\Projects\Repositories\EloquentInvitationRepository;
use App\Projects\Repositories\EloquentProjectRepository;
use App\Projects\Repositories\EloquentTaskRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Routing\Router;
use App\Contracts\Projects\ProjectRepository;

class ProjectModule extends Module
{
    /**
     * The event handler mappings for the module.
     *
     * @var array
     */
    protected $listen = [
        EmailWasInvitedToProject::class => [
            SendInvitationEmail::class,
        ],
        UserWasAddedToProject::class => [
            SendUserAddedToProjectEmail::class,
        ],
    ];

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
        $router->group([
            'prefix' => 'api/v1',
            'as' => 'api.v1.',
            'namespace' => 'App\Projects\Controllers\Api\v1',
            'middleware' => ['api']
        ],
            function (Router $router) {
                $router->group(['prefix' => 'projects', 'as' => 'projects.'], function (Router $router) {
                    $router->get('/', ['as' => 'index', 'uses' => 'ProjectController@index']);
                    $router->get('{project}', ['as' => 'show', 'uses' => 'ProjectController@show']);
                    $router->post('/', ['as' => 'store', 'uses' => 'ProjectController@store']);
                    $router->patch('{project}', ['as' => 'update', 'uses' => 'ProjectController@update']);
                    $router->delete('{project}', ['as' => 'destroy', 'uses' => 'ProjectController@destroy']);
                    $router->patch('{project}/restore', ['as' => 'restore', 'uses' => 'ProjectController@restore']);

                    $router->group(['prefix' => '{project}/users', 'as' => 'users.'], function (Router $router) {
                        $router->get('/', ['as' => 'index', 'uses' => 'ProjectUserController@index']);
                        $router->patch('{user}/promote',
                            ['as' => 'promote', 'uses' => 'ProjectUserController@promote']);
                        $router->patch('{user}/demote', ['as' => 'demote', 'uses' => 'ProjectUserController@demote']);
                        $router->post('invite', ['as' => 'invite', 'uses' => 'ProjectUserController@invite']);
                    });

                    $router->group(['prefix' => '{project}/tasks', 'as' => 'tasks.'], function (Router $router) {
                        $router->get('/', ['as' => 'index', 'uses' => 'ProjectTaskController@index']);
                        $router->post('/', ['as' => 'store', 'uses' => 'ProjectTaskController@store']);
                        $router->patch('{task}', ['as' => 'update', 'uses' => 'ProjectTaskController@update']);
                        $router->patch('{task}/complete',
                            ['as' => 'complete', 'uses' => 'ProjectTaskController@complete']);
                        $router->delete('{task}', ['as' => 'destroy', 'uses' => 'ProjectTaskController@destroy']);
                        $router->patch('{task}/restore',
                            ['as' => 'restore', 'uses' => 'ProjectTaskController@restore']);
                    });

//                    TODO: Add comments
//                    $router->group(['prefix' =>'{project}/comments', 'as' => 'comments.'], function (Router $router) {
//                        $router->get('/', ['as' => 'index', 'uses' => 'ProjectCommentController@index']);
//                        $router->get('{comment}', ['as' => 'show', 'uses' => 'ProjectCommentController@show']);
//                        $router->post('/', ['as' => 'store', 'uses' => 'ProjectCommentController@store']);
//                        $router->patch('{comment}', ['as' => 'update', 'uses' => 'ProjectCommentController@update']);
//                    });
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

            'projects.task.create' => 'Create tasks',
            'projects.task.update' => 'Update tasks',
            'projects.task.complete' => 'Complete tasks',
            'projects.task.destroy' => 'Remove tasks',
            'projects.task.restore' => 'Restore tasks',
            'projects.task.assign' => 'Assign tasks',
        ];
    }

    /**
     * Binds the route model bindings for the module.
     *
     * @param Router $router
     */
    public function bindModuleRouteBindings(Router $router)
    {
        $router->bind('project', 'App\Projects\Binders\RouteModelBinder@project');
        $router->bind('task', 'App\Projects\Binders\RouteModelBinder@task');
        $router->bind('user', 'App\Projects\Binders\RouteModelBinder@user');
    }

    /**
     * Bootstrap the module.
     */
    public function bootModule()
    {
    }
}
