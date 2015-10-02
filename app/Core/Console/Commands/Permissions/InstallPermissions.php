<?php

namespace App\Core\Console\Commands\Permissions;

use App\Core\ACL\Models\Permission;
use App\Contracts\ACL\PermissionRepository;
use Illuminate\Console\Command;

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
     * @var App\Contracts\ACL\PermissionRepository
     */
    protected $permissions;

   /**
    * Create a new command instance.
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
        $needed = app('permissions');
        $installed = $this->parsePermissionObjects($this->permissions->all());

        $toinstall = array_diff($needed, $installed);
        $toremove = array_diff($installed, $needed);

        foreach ($toinstall as $pattern => $name) {
            $permission = (new Permission())->setPattern($pattern)
                                        ->setName($name);

            $this->permissions->persist($permission);

            $this->info(
                sprintf('Stored permission: %s => %s', $permission->getPattern(), $permission->getName())
            );
        }

        $this->permissions->flush();

        foreach ($toremove as $pattern => $name) {
            $permission = $this->permissions->findByPattern($pattern);

            $this->permissions->remove($permission);

            $this->error(
                sprintf('Deleted permission: %s => %s', $permission->getPattern(), $permission->getName())
            );
        }
    }

   /**
    * Turn a permission object array to an array where the permission patterns
    * are the keys, and the names are the values.
    *
    * @param  array  $permissions
    *
    * @return array
    */
   private function parsePermissionObjects(array $permissions)
   {
       $parsed = [];

       foreach ($permissions as $permission) {
           $parsed[$permission->getPattern()] = $permission->getName();
       }

       return $parsed;
   }
}
