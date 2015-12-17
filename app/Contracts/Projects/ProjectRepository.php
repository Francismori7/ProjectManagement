<?php

namespace App\Contracts\Projects;

use App\Auth\Models\User;
use App\Contracts\Core\BaseRepository;
use App\Projects\Models\Project;
use Illuminate\Database\Eloquent\Collection;

interface ProjectRepository extends BaseRepository
{
    /**
     * Returns all the Projects.
     *
     * @return Collection All projects.
     */
    public function findAll();

    /**
     * Returns all the Projects.
     *
     * @param array $relations
     * @return Collection All projects.
     */
    public function all(array $relations = []);

    /**
     * Find a project entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Project|null The project.
     */
    public function find($uuid, array $relations = []);

    /**
     * Find a project entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Project|null The project.
     */
    public function findByUUID($uuid, array $relations = []);

    /**
     * Find all project models by user.
     *
     * @param User $user The user
     * @param array $relations
     * @return Collection Projects for the user.
     */
    public function findByUser(User $user, $relations = []);
}
