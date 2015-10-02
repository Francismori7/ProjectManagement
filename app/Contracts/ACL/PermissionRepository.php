<?php

namespace App\Contracts\ACL;

use App\Core\ACL\Models\Permission;
use Illuminate\Database\Eloquent\Collection;

interface PermissionRepository
{
    /**
     * Returns all the Permissions.
     *
     * @return Collection
     */
    public function all();

    /**
     * Find a permission by it's id.
     *
     * @param int $id
     *
     * @return Permission
     */
    public function findById($id);

    /**
     * Find a permission by a pattern.
     *
     * @param string $pattern
     *
     * @return Permission
     */
    public function findByPattern($pattern);
}