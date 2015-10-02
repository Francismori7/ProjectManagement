<?php

namespace App\Auth\Traits;

use App\Auth\Models\Role;

trait HasRoles
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Auth\Models\Role", inversedBy="role_user")
     *
     * @var Doctrine\Common\Collections\ArrayCollection|App\Auth\Models\Role[]
     */
    protected $roles;

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
        $this->roles->add($role);
    }

    /**
     * Remove a role from the object.
     *
     * @param Role $role
     */
    public function removeRole(Role $role)
    {
        $this->roles->remove($role);
    }

    /**
     * Get all the object's roles.
     *
     * @return Doctrine\Common\Collections\ArrayCollection|App\Auth\Models\Role[]
     */
    public function getRoles()
    {
        return $this->roles;
    }
}