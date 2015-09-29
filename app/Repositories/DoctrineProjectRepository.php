<?php

namespace App\Repositories;

use App\Project;
use App\Repositories\Contracts\ProjectRepository;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineProjectRepository extends EntityRepository implements ProjectRepository
{
    use Paginatable;

    /**
     * Find a project entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return Project The project.
     */
    public function findByUUID($uuid)
    {
        return $this->_em->find(Project::class, $uuid);
    }

    /**
     * Find a project entity by its slug.
     *
     * @param string $slug The slug to look for in the database.
     * @return Project The project.
     */
    public function findBySlug($slug)
    {
        return $this->_em->findOneBySlug($slug);
    }

    /**
     * Saves a Project to the database.
     *
     * @param Project $project
     */
    public function save(Project $project)
    {
        $this->persist($project);
    }

    /**
     * Sets the Project entity to be persisted to the database on the next database transaction commit.
     *
     * @param Project $project The Project to save to the database.
     */
    public function persist(Project $project)
    {
        $this->_em->persist($project);
    }

    /**
     * Commits a database transaction.
     *
     * @param Project $project
     */
    public function flush(Project $project = null)
    {
        $this->_em->flush($project);
    }

    /**
     * Soft-deletes/removes a Project.
     *
     * @param Project $project The Project to delete.
     */
    public function delete(Project $project)
    {
        $this->_em->remove($project);
    }
}