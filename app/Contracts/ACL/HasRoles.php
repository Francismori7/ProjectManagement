<?php

namespace App\Contracts\ACL;

use App\Auth\Models\Role;

interface HasRoles
{
    /**
     * Check if the object has a given role.
     *
     * @param  Role    $role
     * @return boolean
     */
    public function hasRole(Role $role);

    /**
     * Add a role to the object.
     *
     * @param  Role $role
     * @return void
     */
    public function addRole(Role $role);

    /**
     * Remove a role from the object.
     *
     * @param  Role   $role
     * @return void
     */
    public function removeRole(Role $role);

    /**
     * Get all the object's roles.
     *
     * @return Doctrine\Common\Collections\ArrayCollection|App\Auth\Models\Role[]
     */
    public function getRoles();
}
