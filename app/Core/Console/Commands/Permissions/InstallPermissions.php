<?php

namespace App\Core\Console\Commands\Permissions;

use App\Core\ACL\Models\Permission;
use App\Contracts\ACL\PermissionRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class InstallPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Collect and install the permissions from all the modules.';

    /**
     * @var PermissionRepository
     */
    protected $permissions;

    /**
     * Create a new command instance.
     *
     * @param PermissionRepository $permissions
     */
    public function __construct(PermissionRepository $permissions)
    {
        parent::__construct();

        $this->permissions = $permissions;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $needed = collect(app('permissions'));
        $installed = $this->parsePermissionObjects($this->permissions->all());

        $toInstall = $needed->diff($installed);
        $toRemove = $installed->diff($needed);

        foreach ($toRemove as $pattern => $name) {
            $permission = $this->permissions->findByPattern($pattern);

            $this->permissions->remove($permission);

            $this->error(
                sprintf('Deleted permission: %s => %s', $permission->getPattern(), $permission->getName())
            );
        }

        $this->permissions->flush();

        foreach ($toInstall as $pattern => $name) {
            $permission = (new Permission())->setPattern($pattern)
                ->setName($name);

            $this->permissions->create($permission);

            $this->info(
                sprintf('Stored permission: %s => %s', $permission->getPattern(), $permission->getName())
            );
        }

        $this->permissions->flush();
    }

    /**
     * Turn a permission object array to an array where the permission patterns
     * are the keys, and the names are the values.
     *
     * @param  Collection $permissions
     *
     * @return Collection
     */
    private function parsePermissionObjects(Collection $permissions)
    {
        $parsed = new Collection();

        $permissions->each(function (Permission $permission) use ($parsed) {
            $parsed->put($permission->getPattern(), $permission->getName());
        });

        return $parsed->sort();
    }
}
