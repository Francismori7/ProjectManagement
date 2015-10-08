<?php

namespace App\Auth\Repositories;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Repositories\DoctrineBaseRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\ORM\QueryBuilder;
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
     * @param array $eagerLoads
     * @return Collection All users.
     */
    public function all(array $eagerLoads = [])
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        $queryBuilder->select(
            array_merge(
                ['u'],
                array_keys($eagerLoads)
            ))
            ->from(User::class, 'u');

        $this->eagerLoadRelationships($eagerLoads, $queryBuilder);

        return Collection::make($queryBuilder->getQuery()->getResult());
    }

    /**
     * Adds the eager loading using LEFT JOIN to the current query.
     *
     * @param array $eagerLoads
     * @param $queryBuilder
     */
    protected function eagerLoadRelationships(array $eagerLoads, QueryBuilder $queryBuilder)
    {
        foreach ($eagerLoads as $key => $relationship) {
            $queryBuilder->leftJoin('u.' . $relationship, $key);
        }
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.=
     * @param array $eagerLoads
     * @return User|null The user.
     */
    public function find($uuid, array $eagerLoads = [])
    {
        return $this->findByUUID($uuid, $eagerLoads);
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @param array $eagerLoads
     * @return User|null The user.
     */
    public function findByUUID($uuid, array $eagerLoads = [])
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            $queryBuilder->select(array_merge(['u'], array_keys($eagerLoads)))
                ->from(User::class, 'u')
                ->where($queryBuilder->expr()->eq('u.id', ':uuid'))
                ->setParameter('uuid', $uuid);

            $this->eagerLoadRelationships($eagerLoads, $queryBuilder);

            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find a user entity by its username.
     *
     * @param string $username The username to look for in the database.
     * @param array $eagerLoads
     * @return User|null The user.
     */
    public function findByUsername($username, array $eagerLoads = [])
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            $queryBuilder->select(array_merge(['u'], array_keys($eagerLoads)))
                ->from(User::class, 'u')
                ->where($queryBuilder->expr()->eq('u.username', ':username'))
                ->setParameter('username', $username);

            $this->eagerLoadRelationships($eagerLoads, $queryBuilder);

            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }

    /**
     * Find a user entity by its email.
     *
     * @param string $email The email to look for in the database.
     * @param array $eagerLoads
     * @return User|null The user.
     */
    public function findByEmail($email, array $eagerLoads = [])
    {
        $queryBuilder = $this->_em->createQueryBuilder();

        try {
            $queryBuilder->select(array_merge(['u'], array_keys($eagerLoads)))
                ->from(User::class, 'u')
                ->where($queryBuilder->expr()->eq('u.email', ':email'))
                ->setParameter('email', $email);

            $this->eagerLoadRelationships($eagerLoads, $queryBuilder);

            return $queryBuilder->getQuery()->getSingleResult();
        } catch (NoResultException $e) {
            return null;
        }
    }
}
