<?php

namespace App\Contracts\Auth;

use App\Auth\Models\Role;
use App\Contracts\Core\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface RoleRepository extends BaseRepository
{
    /**
     * Returns all the Roles.
     *
     * @return Collection All roles.
     */
    public function findAll();

    /**
     * Returns all the Roles.
     *
     * @param array $relations
     * @return Collection All roles.
     */
    public function all(array $relations = []);

    /**
     * Find a role model by ID.
     *
     * @param int $id The identifier to look for in the database.
     * @param array $relations
     * @return Role|null The role.
     */
    public function find($id, array $relations = []);

    /**
     * Find a role model by ID.
     *
     * @param int $id The identifier to look for in the database.
     * @param array $relations
     * @return Role|null The role.
     */
    public function findById($id, array $relations = []);
}
