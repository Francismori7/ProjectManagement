<?php

namespace App\Projects\Repositories;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Repositories\EloquentBaseRepository;
use App\Projects\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class EloquentProjectRepository extends EloquentBaseRepository implements ProjectRepository
{
    /**
     * Returns all the Projects.
     *
     * @return Collection All projects.
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Projects.
     *
     * @param array $relations
     * @return Collection All projects.
     */
    public function all(array $relations = [])
    {
        return Project::with($relations)->get();
    }

    /**
     * Find a project entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Project|null The project.
     */
    public function find($uuid, array $relations = [])
    {
        return $this->findByUUID($uuid);
    }

    /**
     * Find a project entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Project|null The project.
     */
    public function findByUUID($uuid, array $relations = [])
    {
        return Project::with($relations)->where('id', $uuid)->first();
    }
}
