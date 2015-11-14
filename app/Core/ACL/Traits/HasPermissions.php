<?php

namespace App\Core\ACL\Traits;

use App\Core\ACL\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

trait HasPermissions
{
    /**
     * Check if the object has a certain permission.
     *
     * @param  Permission|string $perm
     * @return bool
     */
    public function hasPermission($perm)
    {
        if ($perm instanceof Permission) {
            $perm = $perm->pattern;
        }

        $pattern = $this->getPermissionRegex($perm);

        foreach ($this->permissions as $permission) {
            if (preg_match($pattern, $permission->pattern)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get the regex pattern for a given permission pattern.
     *
     * @param  string $pattern
     * @return string
     */
    private function getPermissionRegex($pattern)
    {
        $pattern = str_replace(['.', '*'], ["\.", '.*'], $pattern);

        return sprintf('/^%s$/', $pattern);
    }

    /**
     * Add a permission to the object.
     *
     * @param  Permission $perm
     * @return void
     */
    public function addPermission(Permission $perm)
    {
        $this->permissions()->attach($perm);
    }

    /**
     * This entity can have many permissions.
     *
     * @return mixed
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }

    /**
     * Remove a permission from the object.
     *
     * @param  Permission $perm
     * @return void
     */
    public function removePermission(Permission $perm)
    {
        $this->permissions()->detach($perm);
    }

    /**
     * Returns all the permissions of the object.
     *
     * @return Collection
     */
    public function getPermissions()
    {
        return $this->permissions;
    }
}
