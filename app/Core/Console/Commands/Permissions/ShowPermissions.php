<?php

namespace App\Core\Console\Commands\Permissions;

use App\Contracts\Auth\UserRepository;
use Illuminate\Console\Command;

class ShowPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:show {username}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Show all the permissions for a user.';

    /**
     * @var App\Contracts\Auth\UserRepository
     */
    protected $users;

    /**
     * Create a new command instance.
     */
    public function __construct(UserRepository $users)
    {
        parent::__construct();

        $this->users = $users;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $user = $this->getUser();
        if ($user === null) {
            $this->error("That user does not exist.");
            return;
        }

        $permissions = $user->getPermissions();

        if (count($permissions) === 0) {
            $this->info(sprintf("'%s' doesn't have any permissions.", $user->getUsername()));
            return;
        }

        $this->info(sprintf("'%s' has the following permissions: ", $user->getUsername()));
        foreach ($permissions as $permission) {
            $this->info(sprintf(" - %s => %s", $permission->getPattern(), $permission->getName()));
        }
    }

    /**
     * Get the user from the command parameter.
     *
     * @return App\Auth\Models\User
     */
    private function getUser()
    {
        return $this->users->findByUsername($this->argument('username'));
    }
}
