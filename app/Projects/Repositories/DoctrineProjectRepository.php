<?php

namespace App\Projects\Repositories;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Repositories\DoctrineBaseRepository;
use App\Projects\Models\Project;
use Doctrine\ORM\NoResultException;
use Illuminate\Database\Eloquent\Collection;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineProjectRepository extends DoctrineBaseRepository implements ProjectRepository
{
    use Paginatable;

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
     * @return Collection All projects.
     */
    public function all()
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return Collection::make($queryBuilder->select('p')
            ->from(Project::class, 'p')
            ->getQuery()
            ->getResult());
    }

    /**
     * Find a project entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return Project|null The project.
     */
    public function find($uuid)
    {
        return $this->findByUUID($uuid);
    }

    /**
     * Find a project entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return Project|null The project.
     */
    public function findByUUID($uuid)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            return $queryBuilder->select('p')
                ->from(Project::class, 'p')
                ->where($queryBuilder->expr()->eq('p.id', ':uuid'))
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find a project entity by its slug.
     *
     * @param string $slug The slug to look for in the database.
     * @return Project|null The project.
     */
    public function findBySlug($slug)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            return $queryBuilder->select('p')
                ->from(Project::class, 'p')
                ->where($queryBuilder->expr()->eq('p.slug', ':slug'))
                ->setParameter('slug', $slug)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }
}
