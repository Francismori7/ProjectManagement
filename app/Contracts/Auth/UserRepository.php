<?php

namespace App\Contracts\Auth;

use App\Auth\Models\User;
use App\Contracts\Core\BaseRepository;
use Illuminate\Database\Eloquent\Collection;

interface UserRepository extends BaseRepository
{
    /**
     * Returns all the Users.
     *
     * @return Collection All users.
     */
    public function findAll();

    /**
     * Returns all the Users.
     *
     * @return Collection All users.
     */
    public function all();

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return User|null The user.
     */
    public function find($uuid);

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @return User|null The user.
     */
    public function findByUUID($uuid);

    /**
     * Find a user entity by its username.
     *
     * @param string $username The username to look for in the database.
     * @return User|null The user.
     */
    public function findByUsername($username);

    /**
     * Find a user entity by its email.
     *
     * @param string $email The email to look for in the database.
     * @return User|null The user.
     */
    public function findByEmail($email);
}