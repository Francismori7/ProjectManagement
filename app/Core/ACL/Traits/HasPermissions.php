<?php

namespace App\Core\ACL\Traits;

use App\Core\ACL\Models\Permission;

trait HasPermissions
{
    /**
     * @ORM\ManyToMany(targetEntity="App\Core\ACL\Models\Permission")
     *
     * @var ArrayCollection|App\Auth\Models\Permission[]
     */
    protected $permissions;

    /**
     * Check if the object has a certain permission.
     *
     * @param Permission $perm
     *
     * @return bool
     */
    public function hasPermission(Permission $perm)
    {
        $pattern = $this->getPermissionRegex($perm);

        foreach ($this->getPermissions() as $permission) {
            if (preg_match($pattern, $permission->getPattern())) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add a permission to the object.
     *
     * @param Permission $perm
     */
    public function addPermission(Permission $perm)
    {
        $this->permissions->add($perm);
    }

    /**
     * Remove a permission from the object.
     *
     * @param Permission $perm
     */
    public function removePermission(Permission $perm)
    {
        $this->permissions->remove($perm);
    }

    /**
     * Get the regex pattern for a given permission.
     *
     * @param Permission $permission
     *
     * @return string
     */
    private function getPermissionRegex(Permission $permission)
    {
        $pattern = str_replace('.', "\.", $permission->getPattern());
        $pattern = str_replace('*', '.*', $pattern);

        return sprintf('/^%s$/', $pattern);
    }

    /**
     * Returns all the permissions of the object.
     *
     * @return ArrayCollection|App\Auth\Models\Permission[]
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
