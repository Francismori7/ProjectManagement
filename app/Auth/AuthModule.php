<?php

namespace App\Auth;

use App\Auth\Repositories\EloquentRoleRepository;
use App\Auth\Repositories\EloquentUserRepository;
use App\Contracts\Auth\RoleRepository;
use App\Contracts\Projects\InvitationRepository;
use App\Core\Module;
use App\Projects\Models\Invitation;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use App\Contracts\Auth\UserRepository;

class AuthModule extends Module
{
    /**
     * Register all the bindings on the service container.
     */
    public function registerContainerBindings()
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(RoleRepository::class, EloquentRoleRepository::class);
    }

    /**
     * Map all the routes needed by this module.
     *
     * @param  Router $router
     */
    public function map(Router $router)
    {
        $router->group(['prefix' => 'api/v1', 'as' => 'api.v1.', 'namespace' => 'App\Auth\Controllers\Api\v1'],
            function (Router $router) {
                $router->group(['prefix' => 'auth', 'as' => 'auth.'], function (Router $router) {
                    $router->post('login', ['as' => 'login', 'uses' => 'AuthenticationController@login']);
                    $router->post('register/{invitation}',
                        ['as' => 'register', 'uses' => 'AuthenticationController@register']);

                    $router->get('me', ['as' => 'me', 'uses' => 'AuthenticationController@me']);
                    $router->get('logout', ['as' => 'logout', 'uses' => 'AuthenticationController@logout']);

                    $router->post('email', ['as' => 'email', 'uses' => 'AuthenticationController@email']);
                    $router->post('reset', ['as' => 'reset', 'uses' => 'AuthenticationController@reset']);
                });

                $router->group(['prefix' => 'profile', 'as' => 'profile.'], function (Router $router) {
                    /*
                     * Duplicate /me route
                     */
                    $router->get('me', ['as' => 'me', 'uses' => 'AuthenticationController@me']);

                    $router->post('update', ['as' => 'update', 'uses' => 'ProfileController@update']);
                });
            });
    }

    /**
     * Binds the route model bindings for the module.
     *
     * @param Router $router
     */
    public function bindModuleRouteBindings(Router $router)
    {
        $router->bind('invitation', function ($id) {
            $invitation = $this->app->make(InvitationRepository::class)->findByUUID($id);

            if(!$invitation) {
                throw (new ModelNotFoundException)->setModel(Invitation::class);
            }
            return $invitation;
        });
    }

    /**
     * Returns an array of the available permissions for the module.
     *
     * @return array
     */
    public function getModulePermissions()
    {
        return [
            'auth.users.create' => 'Create Users',
            'auth.users.update' => 'Edit Users',
            'auth.users.destroy' => 'Remove Users',
        ];
    }
}
