<?php

namespace App\Core\Providers;

use App\Auth\Models\User;
use App\Contracts\Projects\ProjectRepository;
use App\Projects\Repositories\DoctrineProjectRepository;
use App\Auth\Repositories\DoctrineUserRepository;
use App\Contracts\Auth\UserRepository;
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
