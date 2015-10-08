<?php

namespace App\Core\ACL\Repositories;

use App\Core\Repositories\DoctrineBaseRepository;
use App\Core\ACL\Models\Permission;
use App\Contracts\ACL\PermissionRepository;
use Doctrine\ORM\NoResultException;
use Illuminate\Database\Eloquent\Collection;

class DoctrinePermissionRepository extends DoctrineBaseRepository implements PermissionRepository
{
    /**
     * Returns all the Permissions.
     *
     * @return Collection
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Permissions.
     *
     * @return Collection
     */
    public function all()
    {
        $qb = $this->_em->createQueryBuilder();

        return Collection::make($qb->select('p')
            ->from(Permission::class, 'p')
            ->getQuery()
            ->getResult());
    }

    /**
     * Find a permission by it's id.
     *
     * @param int $id
     *
     * @return Permission
     */
    public function findById($id)
    {
        $qb = $this->_em->createQueryBuilder();

        try {
            return $qb->select('p')
                ->from(Permission::class, 'p')
                ->where($qb->expr()->eq('p.id', ':id'))
                ->setParameter(':id', $id)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find a permission by a pattern.
     *
     * @param string $pattern
     *
     * @return Permission
     */
    public function findByPattern($pattern)
    {
        $qb = $this->_em->createQueryBuilder();

        try {
            return $qb->select('p')
                ->from(Permission::class, 'p')
                ->where($qb->expr()->eq('p.pattern', ':pattern'))
                ->setParameter(':pattern', $pattern)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }
}
