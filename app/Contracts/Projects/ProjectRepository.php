<?php

namespace App\Contracts\Projects;

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
     * @return Collection|Project[] All projects.
     */
    public function all();

    /**
     * Find a project entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return Project|null The project.
     */
    public function find($uuid);

    /**
     * Find a project entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return Project|null The project.
     */
    public function findByUUID($uuid);

    /**
     * Find a project entity by its slug.
     *
     * @param string $slug The slug to look for in the database.
     * @return Project|null The project.
     */
    public function findBySlug($slug);
}