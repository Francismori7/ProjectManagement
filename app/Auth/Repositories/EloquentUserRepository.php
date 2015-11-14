<?php

namespace App\Auth\Repositories;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Repositories\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Collection;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
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
     * @param array $relations
     * @return Collection All users.
     */
    public function all(array $relations = [])
    {
        return User::with($relations)->get();
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.=
     * @param array $relations
     * @return User|null The user.
     */
    public function find($uuid, array $relations = [])
    {
        return $this->findByUUID($uuid, $relations);
    }

    /**
     * Find a user entity by UUID.
     *
     * @param int $uuid The identifier to look for in the database.
     * @param array $relations
     * @return User|null The user.
     */
    public function findByUUID($uuid, array $relations = [])
    {
        return User::where('id', $uuid)->with($relations)->first();
    }

    /**
     * Find a user entity by its username.
     *
     * @param string $username The username to look for in the database.
     * @param array $relations
     * @return User|null The user.
     */
    public function findByUsername($username, array $relations = [])
    {
        return User::where('username', $username)->with($relations)->first();
    }

    /**
     * Find a user entity by its email.
     *
     * @param string $email The email to look for in the database.
     * @param array $relations
     * @return User|null The user.
     */
    public function findByEmail($email, array $relations = [])
    {
        return User::where('email', $email)->with($relations)->first();
    }
}
