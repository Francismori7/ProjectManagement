<?php

namespace App\Core\ACL\Repositories;

use App\Contracts\ACL\PermissionRepository;
use App\Core\ACL\Models\Permission;
use App\Core\Repositories\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentPermissionRepository extends EloquentBaseRepository implements PermissionRepository
{
    /**
     * The base model name used for caching.
     *
     * @var string
     */
    protected $modelName = 'permission';

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
        return $this->storeCollectionInCache(
            Permission::all()
        );
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
        return $this->storeModelInCache(
            Permission::whereId($id)->first()
        );
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
        return $this->storeModelInCache(
            Permission::wherePattern($pattern)->first()
        );
    }
}
