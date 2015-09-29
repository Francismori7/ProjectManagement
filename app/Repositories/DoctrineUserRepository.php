<?php

namespace App\Repositories;

use App\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use LaravelDoctrine\ORM\Pagination\Paginatable;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    use Paginatable;

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return User The user.
     */
    public function findByUUID($uuid)
    {
        return $this->_em->find(User::class, $uuid);
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
     * @param User $user
     */
    public function flush(User $user = null)
    {
        /*
         * Here, the interface has no parameters, but the actual implementation has a
         * $entity parameter that allows us to only save the data for the entity we
         * wish to persist.
         */
        $this->_em->flush($user);
    }

    /**
     * Soft-deletes/removes a User.
     * @param User $user The User to delete.
     */
    public function delete(User $user) {
        $this->_em->remove($user);
    }
}