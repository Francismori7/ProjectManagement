<?php

namespace App\Auth\Repositories;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Repositories\EloquentBaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Cache\Repository as CacheRepository;

class EloquentUserRepository extends EloquentBaseRepository implements UserRepository
{
    /**
     * The base model name used for caching.
     *
     * @var string
     */
    protected $modelName = 'user';

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
        return $this->storeCollectionInCache(
            User::with($relations)->get()
        );
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
        return $this->storeModelInCache(
            User::whereId($uuid)->with($relations)->first()
        );
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
        return $this->storeModelInCache(
            User::whereUsername($username)->with($relations)->first()
        );
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
        return $this->storeModelInCache(
            User::whereEmail($email)->with($relations)->first()
        );
    }

    /**
     * EloquentUserRepository constructor.
     *
     * @param CacheRepository $cache
     */
    public function __construct(CacheRepository $cache)
    {
        parent::__construct($cache);
    }
}
