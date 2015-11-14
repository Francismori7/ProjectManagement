<?php

namespace App\Core\ACL\Repositories;

use App\Core\ACL\Models\Permission;
use App\Contracts\ACL\PermissionRepository;
use App\Core\Repositories\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentPermissionRepository extends EloquentBaseRepository implements PermissionRepository
{
    /**
     * Returns all the Permissions.
     *
     * @return Collection
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Permissions.
     *
     * @return Collection
     */
    public function all()
    {
        return Permission::all();
    }

    /**
     * Find a permission by it's id.
     *
     * @param int $id
     *
     * @return Permission
     */
    public function findById($id)
    {
        return Permission::where('id', $id)->first();
    }

    /**
     * Find a permission by a pattern.
     *
     * @param string $pattern
     *
     * @return Permission
     */
    public function findByPattern($pattern)
    {
        return Permission::where('pattern', $pattern)->first();
    }
}
