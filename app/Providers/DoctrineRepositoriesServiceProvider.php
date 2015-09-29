<?php

namespace App\Providers;

use App\Repositories\Contracts\ProjectRepository;
use App\Repositories\DoctrineProjectRepository;
use App\Repositories\DoctrineUserRepository;
use App\Repositories\Contracts\UserRepository;
use App\User;
use Doctrine\ORM\Mapping\ClassMetadata;
use Illuminate\Support\ServiceProvider;

class DoctrineRepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, function ($app) {
            return new DoctrineUserRepository(
                $app['em'],
                new ClassMetadata(User::class));
        });

        $this->app->bind(ProjectRepository::class, function ($app) {
            return new DoctrineProjectRepository(
                $app['em'],
                new ClassMetadata(User::class));
        });
    }
}
