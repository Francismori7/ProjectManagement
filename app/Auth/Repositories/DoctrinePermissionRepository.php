<?php

namespace App\Auth\Repositories;

use App\Auth\Models\Permission;
use Doctrine\ORM\EntityRepository;
use App\Contracts\ACL\PermissionRepository;

class DoctrinePermissionRepository extends EntityRepository implements PermissionRepository
{
    /**
     * Returns all the Permissions.
     *
     * @return Collection|Permission[]
     */
    public function all()
    {
        $qb = $this->_em->createQueryBuilder();

        return $qb->select('p')
            ->from(Permission::class, 'p')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find a permission by it's id.
     *
     * @param  int $id
     * @return App\Auth\Models\Permission
     */
    public function findById($id)
    {
        return $this->_em->find(Permission::class, $id);
    }

    /**
     * Find a permission by a pattern.
     *
     * @param  string $pattern
     * @return App\Auth\Models\Permission
     */
    public function findByPattern($pattern)
    {
        $qb = $this->_em->createQueryBuilder();

        return $qb->select('p')
            ->from(Permission::class, 'p')
            ->where($qb->expr()->eq('p.pattern', ':pattern'))
            ->setParameter(':pattern', $pattern)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Sets the permission entity to be persisted to the database on the next
     * database transaction commit.
     *
     * @param  Permission $permission
     * @return void
     */
    public function persist(Permission $permission)
    {
        $this->_em->persist($permission);
    }

    /**
     * Commits a database transaction
     *
     * @param  Permission $permission
     * @return void
     */
    public function flush(Permission $permission = null)
    {
        $this->_em->flush($permission);
    }

    /**
     * Removes a permission.
     *
     * @param  Permission $permission
     * @return void
     */
    public function delete(Permission $permission)
    {
        $this->_em->remove($permission);
    }
}
