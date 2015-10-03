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
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'App\Auth\Controllers'], function (Router $router) {
            $router->get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
            $router->post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
            $router->get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

            $router->get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
            $router->post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);

            $router->group(['prefix' => 'password', 'as' => 'password.'], function (Router $router) {
                $router->get('email', ['as' => 'email', 'uses' => 'PasswordController@getEmail']);
                $router->post('email', ['as' => 'email', 'uses' => 'PasswordController@postEmail']);

                $router->get('reset/{token}', ['as' => 'reset', 'uses' => 'PasswordController@getReset']);
                $router->post('reset', ['as' => 'reset', 'uses' => 'PasswordController@postReset']);
            });
        });

        $router->group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'App\Auth\Controllers'], function (Router $router) {
           $router->get('edit', ['as' => 'edit', 'uses'=>'ProfileController@edit']);
           $router->patch('/', ['as' => 'update', 'uses'=>'ProfileController@update']);
        });
    }

    public function getModulePermissions()
    {
        return [
            'users.create' => 'Create Users',
            'users.update' => 'Edit Users',
            'users.destroy' => 'Remove Users',
        ];
    }
}
