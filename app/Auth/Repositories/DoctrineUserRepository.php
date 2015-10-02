<?php

namespace App\Auth\Repositories;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Repositories\DoctrineBaseRepository;
use Doctrine\ORM\NoResultException;
use Illuminate\Database\Eloquent\Collection;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineUserRepository extends DoctrineBaseRepository implements UserRepository
{
    use Paginatable;

    /**
     * Returns all the Users.
     *
     * @return Collection All users.
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Users.
     *
     * @return Collection All users.
     */
    public function all()
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        return Collection::make($queryBuilder->select('u')
            ->from(User::class, 'u')
            ->getQuery()
            ->getResult());
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return User|null The user.
     */
    public function find($uuid)
    {
        return $this->findByUUID($uuid);
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return User|null The user.
     */
    public function findByUUID($uuid)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            return $queryBuilder->select('u')
                ->from(User::class, 'u')
                ->where($queryBuilder->expr()->eq('u.id', ':uuid'))
                ->setParameter('uuid', $uuid)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find a user entity by its username.
     *
     * @param string $username The username to look for in the database.
     * @return User|null The user.
     */
    public function findByUsername($username)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            return $queryBuilder->select('u')
                ->from(User::class, 'u')
                ->where($queryBuilder->expr()->eq('u.username', ':username'))
                ->setParameter('username', $username)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find a user entity by its email.
     *
     * @param string $email The email to look for in the database.
     * @return User|null The user.
     */
    public function findByEmail($email)
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            return $queryBuilder->select('u')
                ->from(User::class, 'u')
                ->where($queryBuilder->expr()->eq('u.email', ':email'))
                ->setParameter('email', $email)
                ->getQuery()
                ->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }
}