<?php

namespace App\Contracts\Projects;

use App\Projects\Models\Project;
use Doctrine\Common\Collections\Collection;

interface ProjectRepository
{
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
     * @return Project The project.
     */
    public function find($uuid);

    /**
     * Find a project entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return Project The project.
     */
    public function findByUUID($uuid);

    /**
     * Find a project entity by its slug.
     *
     * @param string $slug The slug to look for in the database.
     * @return Project The project.
     */
    public function findBySlug($slug);

    /**
     * Saves a Project to the database.
     *
     * @param Project $project
     */
    public function save(Project $project);

    /**
     * Sets the Project entity to be persisted to the database on the next database transaction commit.
     *
     * @param Project $project The Project to save to the database.
     */
    public function persist(Project $project);

    /**
     * Commits a database transaction.
     *
     * @param Project $project
     */
    public function flush(Project $project = null);

    /**
     * Soft-deletes/removes a Project.
     *
     * @param Project $project The Project to delete.
     */
    public function delete(Project $project);
}