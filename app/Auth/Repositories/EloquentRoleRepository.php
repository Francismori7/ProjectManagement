<?php

namespace App\Auth\Repositories;

use App\Auth\Models\Role;
use App\Contracts\Auth\RoleRepository;
use App\Core\Repositories\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentRoleRepository extends EloquentBaseRepository implements RoleRepository
{
    /**
     * Returns all the Roles.
     *
     * @return Collection All roles.
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Roles.
     *
     * @param array $relations
     * @return Collection All roles.
     */
    public function all(array $relations = [])
    {
        return Role::with($relations)->get();
    }

    /**
     * Find a role entity by ID.
     *
     * @param int $id The identifier to look for in the database.
     * @param array $relations
     * @return Role|null The role.
     */
    public function find($id, array $relations = [])
    {
        return $this->findByID($id, $relations);
    }

    /**
     * Find a role entity by ID.
     *
     * @param int $id The identifier to look for in the database.
     * @param array $relations
     * @return Role|null The role.
     */
    public function findById($id, array $relations = [])
    {
        return Role::where('id', $id)->with($relations)->first();
    }
}
