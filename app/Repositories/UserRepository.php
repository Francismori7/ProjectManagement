<?php
/**
 * Created by PhpStorm.
 * User: 1494770
 * Date: 2015-09-29
 * Time: 10:24
 */
namespace App\Repositories;

use App\User;

interface UserRepository
{
    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return User The user.
     */
    public function findByUUID($uuid);

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
     * @param User $user
     */
    public function flush(User $user = null);

    /**
     * Soft-deletes/removes a User.
     * @param User $user The User to delete.
     */
    public function delete(User $user);
}