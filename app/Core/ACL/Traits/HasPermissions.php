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
    public $permissions;

    /**
     * Check if the object has a certain permission.
     *
     * @param  mixed $perm
     * @return bool
     */
    public function hasPermission($perm)
    {
        if ($perm instanceof Permission) {
            $perm = $perm->getPattern();
        }
        
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
     * @param  Permission $perm
     * @return void
     */
    public function addPermission(Permission $perm)
    {
        $this->permissions->add($perm);
    }

    /**
     * Remove a permission from the object.
     *
     * @param  Permission $perm
     * @return void
     */
    public function removePermission(Permission $perm)
    {
        $this->permissions->removeElement($perm);
    }

    /**
     * Get the regex pattern for a given permission pattern.
     *
     * @param  string $pattern
     * @return string
     */
    private function getPermissionRegex($pattern)
    {
        $pattern = str_replace('.', "\.", $pattern);
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
