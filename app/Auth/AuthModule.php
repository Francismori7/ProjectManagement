<?php

namespace App\Auth;

use App\Auth\Models\User;
use App\Core\Module;
use Illuminate\Routing\Router;
use App\Contracts\Auth\UserRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Auth\Repositories\DoctrineUserRepository;

class AuthModule extends Module
{
    /**
     * Register all the bindings on the service container.
     */
    public function registerContainerBindings()
    {
        $this->app->bind(UserRepository::class, function ($app) {
            return new DoctrineUserRepository(
                $app['em'],
                new ClassMetadata(User::class));
        });
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
                    $router->post('register', ['as' => 'register', 'uses' => 'AuthenticationController@register']);

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
     * Returns an array of the available permissions for the module.
     *
     * @return array
     */
    public function getModulePermissions()
    {
        return [
            'users.create' => 'Create Users',
            'users.update' => 'Edit Users',
            'users.destroy' => 'Remove Users',
        ];
    }
}
