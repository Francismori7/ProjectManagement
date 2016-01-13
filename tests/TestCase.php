<?php

namespace Tests;

use App\Auth\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Contracts\Console\Kernel;

class TestCase extends BaseTestCase
{
    use DatabaseMigrations;

    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * Installs the permissions.
     */
    protected function setUpPermissions()
    {
        $this->artisan('permissions:install');
    }

    /**
     * Gives permissions to a test user.
     *
     * @param User $user
     * @param array|string $patterns
     */
    protected function giveUserPermission(User $user, $patterns)
    {
        if (is_array($patterns)) {
            foreach ($patterns as $pattern) {
                $this->artisan('permissions:give', ['username' => $user->username, 'pattern' => $pattern]);
            }
            return;
        }
        $this->artisan('permissions:give', ['username' => $user->username, 'pattern' => $patterns]);
    }
}
