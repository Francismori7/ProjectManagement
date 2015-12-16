<?php

namespace App\Projects\Repositories;

use App\Auth\Models\User;
use App\Contracts\Projects\ProjectRepository;
use App\Core\Repositories\EloquentBaseRepository;
use App\Projects\Models\Project;
use Illuminate\Support\Collection;

class EloquentProjectRepository extends EloquentBaseRepository implements ProjectRepository
{
    /**
     * The base model name used for caching.
     *
     * @var string
     */
    protected $modelName = 'project';

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
        return $this->storeCollectionInCache(
            Project::with($relations)->get()
        );
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
        return $this->storeModelInCache(
            Project::with($relations)->whereId($uuid)->first()
        );
    }
}
