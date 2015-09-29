<?php

namespace App\Core\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $debugStack = new \Doctrine\DBAL\Logging\DebugStack();
        \EntityManager::getConnection()->getConfiguration()->setSQLLogger($debugStack);
        $this->app['debugbar']->addCollector(new \DebugBar\Bridge\DoctrineCollector($debugStack));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
