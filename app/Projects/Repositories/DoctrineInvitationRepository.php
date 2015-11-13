<?php

namespace App\Projects\Repositories;

use App\Contracts\Projects\InvitationRepository;
use App\Core\Repositories\DoctrineBaseRepository;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use Doctrine\ORM\NoResultException;
use Illuminate\Database\Eloquent\Collection;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineInvitationRepository extends DoctrineBaseRepository implements InvitationRepository
{
    use Paginatable;

    /**
     * Returns all the Invitations.
     *
     * @return Collection All invitations.
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Invitations.
     *
     * @return Collection All invitations.
     */
    public function all()
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return Collection::make($queryBuilder->select('i')
            ->from(Invitation::class, 'i')
            ->getQuery()
            ->getResult());
    }

    /**
     * Find an invitation entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @return Invitation|null The invitation.
     */
    public function find($uuid)
    {
        return $this->findByUUID($uuid);
    }

    /**
     * Find an invitation entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @return Invitation|null The invitation.
     */
    public function findByUUID($uuid)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            return $queryBuilder->select('i')
                ->from(Invitation::class, 'i')
                ->where($queryBuilder->expr()->eq('i.id', ':uuid'))
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find an invitation entity by email.
     *
     * @param string $email The email to look for in the database.
     * @return Invitation|null The invitation.
     */
    public function findByEmail($email)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            return $queryBuilder->select('i')
                ->from(Invitation::class, 'i')
                ->where($queryBuilder->expr()->eq('i.email', ':email'))
                ->setParameter('email', $email)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find all invitations for a given project.
     *
     * @param Project $project The project to look for in the database.
     * @return Collection The invitations.
     */
    public function findByProject(Project $project)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return Collection::make($queryBuilder->select('i')
            ->from(Invitation::class, 'i')
            ->where($queryBuilder->expr()->eq('i.project', ':project'))
            ->setParameter('project', $project->getId())
            ->getQuery()
            ->getResult());
    }
}