<?php

namespace App\Contracts\Auth;

use App\Auth\Models\User;
use Doctrine\Common\Collections\Collection;

interface UserRepository
{
    /**
     * Returns all the Users.
     *
     * @return Collection|User[] All users.
     */
    public function all();

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     *
     * @return User The user.
     */
    public function find($uuid);

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     *
     * @return User The user.
     */
    public function findByUUID($uuid);

    /**
     * Find a user entity by its username.
     *
     * @param string $username The username to look for in the database.
     *
     * @return User The user.
     */
    public function findByUsername($username);

    /**
     * Saves a User to the database.
     *
     * @param User $user
     */
    public function save(User $user);

    /**
     * Sets the User entity to be persisted to the database on the next database transaction commit.
     *
     * @param User $user The User to save to the database.
     */
    public function persist(User $user);

    /**
     * Commits a database transaction.
     *
     * @param User $user
     */
    public function flush(User $user = null);

    /**
     * Soft-deletes/removes a User.
     *
     * @param User $user The User to delete.
     */
    public function delete(User $user);
}
