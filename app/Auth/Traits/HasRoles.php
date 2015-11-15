<?php

namespace App\Auth\Traits;

use App\Auth\Models\Role;
use Illuminate\Database\Eloquent\Collection;

trait HasRoles
{
    /**
     * This entity belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the object has a given role.
     *
     * @param Role $role
     *
     * @return bool
     */
    public function hasRole(Role $role)
    {
        return $this->roles->contains($role);
    }

    /**
     * Add a role to the object.
     *
     * @param Role $role
     */
    public function addRole(Role $role)
    {
        $this->roles()->attach($role);
    }

    /**
     * Remove a role from the object.
     *
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        $this->roles()->detach($role);
    }

    /**
     * @return Collection
     */
    public function getRoles()
    {
        return $this->roles;
    }
}
