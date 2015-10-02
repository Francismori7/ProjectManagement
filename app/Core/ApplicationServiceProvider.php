<?php

namespace App\Core;

use Illuminate\Support\ServiceProvider;

class ApplicationServiceProvider extends ServiceProvider
{
    /**
     * Register any container services.
     */
    public function register()
    {
        $this->app->register(CoreModule::class);
    }
}
