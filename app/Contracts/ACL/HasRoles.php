<?php

namespace App\Contracts\ACL;

use App\Auth\Models\Role;
use Illuminate\Database\Eloquent\Collection;

interface HasRoles
{
    /**
     * Check if the object has a given role.
     *
     * @param Role $role
     *
     * @return bool
     */
    public function hasRole(Role $role);

    /**
     * Add a role to the object.
     *
     * @param Role $role
     */
    public function addRole(Role $role);

    /**
     * Remove a role from the object.
     *
     * @param Role $role
     */
    public function removeRole(Role $role);

    /**
     * Get all the object's roles.
     *
     * @return Collection
     */
    public function getRoles();
}
