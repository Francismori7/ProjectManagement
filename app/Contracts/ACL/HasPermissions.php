<?php

namespace App\Contracts\ACL;

use App\Core\ACL\Models\Permission;

interface HasPermissions
{
    /**
     * Check if the object has a certain permission.
     *
     * @param  mixed $perm
     * @return bool
     */
    public function hasPermission($perm);

    /**
     * Add a permission to the object.
     *
     * @param  Permission $perm
     * @return void
     */
    public function addPermission(Permission $perm);

    /**
     * Remove a permission from the object.
     *
     * @param  Permission $perm
     * @return void
     */
    public function removePermission(Permission $perm);

    /**
     * Returns all the permissions of the object.
     *
     * @return ArrayCollection|App\Auth\Models\Permission[]
     */
    public function getPermissions();
}
