<?php

namespace App\Auth\Repositories;

use App\Contracts\Auth\UserRepository;
use App\Auth\Models\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    use Paginatable;

    /**
     * Returns all the Users.
     *
     * @return Collection|User[] All users.
     */
    public function all()
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->getQuery()
            ->getResult();
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     *
     * @return User The user.
     */
    public function find($uuid)
    {
        return $this->findByUUID($uuid);
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     *
     * @return User The user.
     */
    public function findByUUID($uuid)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where($queryBuilder->expr()->eq('u.id', ':uuid'))
            ->setParameter('uuid', $uuid)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Find a user entity by its username.
     *
     * @param string $username The username to look for in the database.
     *
     * @return User The user.
     */
    public function findByUsername($username)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->where($queryBuilder->expr()->eq('u.username', ':username'))
            ->setParameter('username', $username)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * Saves a User to the database.
     *
     * @param User $user
     */
    public function save(User $user)
    {
        $this->persist($user);
    }

    /**
     * Sets the User entity to be persisted to the database on the next database transaction commit.
     *
     * @param User $user The User to save to the database.
     */
    public function persist(User $user)
    {
        $this->_em->persist($user);
    }

    /**
     * Commits a database transaction.
     *
     * @param User $user
     */
    public function flush(User $user = null)
    {
        $this->_em->flush($user);
    }

    /**
     * Soft-deletes/removes a User.
     *
     * @param User $user The User to delete.
     */
    public function delete(User $user)
    {
        $this->_em->remove($user);
    }
}
