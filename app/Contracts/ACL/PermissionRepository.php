<?php

namespace App\Contracts\ACL;

use App\Auth\Models\Permission;

interface PermissionRepository
{
    /**
     * Returns all the Permissions.
     *
     * @return Collection|Permission[]
     */
    public function all();

    /**
     * Find a permission by it's id.
     *
     * @param  int $id
     * @return App\Auth\Models\Permission
     */
    public function findById($id);

    /**
     * Find a permission by a pattern.
     *
     * @param  string $pattern
     * @return App\Auth\Models\Permission
     */
    public function findByPattern($pattern);

    /**
     * Sets the permission entity to be persisted to the database on the next
     * database transaction commit.
     *
     * @param  Permission $permission
     * @return void
     */
    public function persist(Permission $permission);

    /**
     * Commits a database transaction
     *
     * @param  Permission $permission
     * @return void
     */
    public function flush(Permission $permission = null);

    /**
     * Removes a permission.
     *
     * @param  Permission $permission
     * @return void
     */
    public function delete(Permission $permission);
}
