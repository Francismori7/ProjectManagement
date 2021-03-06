<?php

namespace App\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Core\Console\Commands\Permissions\InstallPermissions::class,
        \App\Core\Console\Commands\Permissions\ListPermissions::class,
        \App\Core\Console\Commands\Permissions\ShowPermissions::class,
        \App\Core\Console\Commands\Permissions\GivePermission::class,
        \App\Core\Console\Commands\Permissions\RevokePermission::class,
        \App\Core\Console\Commands\Permissions\HasPermission::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param \Illuminate\Console\Scheduling\Schedule $schedule
     */
    protected function schedule(Schedule $schedule)
    {
    }
}
