<?php

namespace App\Core\Console\Commands\Permissions;

use App\Auth\Models\User;
use App\Contracts\ACL\PermissionRepository;
use App\Contracts\Auth\UserRepository;
use App\Core\ACL\Models\Permission;
use Illuminate\Console\Command;

class GivePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:give {username} {pattern}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Give a user a permission.';

    /**
     * @var UserRepository
     */
    protected $users;

    /**
     * @var PermissionRepository
     */
    protected $permissions;

    /**
     * Create a new command instance.
     *
     * @param UserRepository $users
     * @param PermissionRepository $permissions
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
            $this->error('That user does not exist.');
            return;
        }

        $permission = $this->getPermission();
        if ($permission === null) {
            $this->error('That permission does not exist.');
            return;
        }

        $user->addPermission($permission);

        $this->users->save($user);

        $this->info(sprintf("'%s' was given the ability to '%s'", $user->username, $permission->name));
    }

    /**
     * Get a user from the command parameter.
     *
     * @return User
     */
    private function getUser()
    {
        return $this->users->findByUsername($this->argument('username'));
    }

    /**
     * Get a permission from the command parameter.
     *
     * @return Permission
     */
    private function getPermission()
    {
        return $this->permissions->findByPattern($this->argument('pattern'));
    }
}
