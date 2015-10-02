<?php

namespace App\Core\Console\Commands\Permissions;

use App\Contracts\ACL\PermissionRepository;
use Illuminate\Console\Command;

class ListPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permissions:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'View installed permissions.';

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
        $permissions = $this->permissions->all();

        if (count($permissions) === 0) {
            $this->info("There aren't any permissions installed.");
            return;
        }

        foreach ($permissions as $permission) {
            $this->info(sprintf(" - %s => %s", $permission->getPattern(), $permission->getName()));
        }
    }
}
