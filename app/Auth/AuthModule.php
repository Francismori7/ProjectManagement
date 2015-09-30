<?php

namespace App\Auth;

use App\Core\Module;
use Illuminate\Routing\Router;
use App\Contracts\Auth\UserRepository;
use Doctrine\ORM\Mapping\ClassMetadata;
use App\Auth\Repositories\DoctrineUserRepository;

class AuthModule extends Module
{
    /**
     * Register all the bindings on the service container.
     *
     * @return void
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
     * @param  Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['prefix' => 'auth', 'as' => 'auth.', 'namespace' => 'App\Auth\Controllers'], function ($router) {
            $router->get('login', ['as' => 'login', 'uses' => 'AuthController@getLogin']);
            $router->post('login', ['as' => 'login', 'uses' => 'AuthController@postLogin']);
            $router->get('logout', ['as' => 'logout', 'uses' => 'AuthController@getLogout']);

            $router->get('register', ['as' => 'register', 'uses' => 'AuthController@getRegister']);
            $router->post('register', ['as' => 'register', 'uses' => 'AuthController@postRegister']);

            $router->group(['prefix' => 'password', 'as' => 'password.'], function ($router) {
                $router->get('email', ['as' => 'email', 'uses' =>'PasswordController@getEmail']);
                $router->post('email', ['as' => 'email', 'uses' => 'PasswordController@postEmail']);

                $router->get('reset/{token}', ['as' => 'reset', 'uses' => 'PasswordController@getReset']);
                $router->post('reset', ['as' => 'reset', 'uses' => 'PasswordController@postReset']);
            });
        });
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