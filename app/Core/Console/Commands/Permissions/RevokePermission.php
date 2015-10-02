<?php

namespace App\Core\Console\Commands\Permissions;

use App\Contracts\ACL\PermissionRepository;
use App\Contracts\Auth\UserRepository;
use Illuminate\Console\Command;

class RevokePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:revoke {username} {pattern}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revoke a user permission.';

    /**
     * @var App\Contracts\Auth\UserRepository
     */
    protected $users;

    /**
     * @var App\Contracts\ACL\PermissionRepository
     */
    protected $permissions;

    /**
     * Create a new command instance.
     */
    public function __construct(UserRepository $users, PermissionRepository $permissions)
    {
        parent::__construct();

        $this->users = $users;
        $this->permissions = $permissions;
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

        $permission = $this->getPermission();
        if ($permission === null) {
            $this->error("That permission does not exist.");
            return;
        }

        $user->removePermission($permission);

        $this->users->persist($user);
        $this->users->flush();

        $this->info(sprintf("'%s' no longer has the ability to '%s'", $user->getUsername(), $permission->getName()));
    }

    /**
     * Get a user from the command parameter.
     *
     * @return App\Auth\Models\User
     */
    private function getUser()
    {
        return $this->users->findByUsername($this->argument('username'));
    }

    /**
     * Get a permission from the command parameter.
     *
     * @return App\Core\ACL\Models\Permission
     */
    private function getPermission()
    {
        return $this->permissions->findByPattern($this->argument('pattern'));
    }
}
