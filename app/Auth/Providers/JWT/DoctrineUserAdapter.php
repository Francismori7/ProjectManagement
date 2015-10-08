<?php

namespace App\Auth\Providers\JWT;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Providers\User\UserInterface;

class DoctrineUserAdapter implements UserInterface
{
    /**
     * @var User
     */
    protected $user;

    /**
     * Create a new User instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the user by the given key, value.
     *
     * @param string $key (id, username, email)
     * @param mixed $value
     *
     * @return User|null
     */
    public function getBy($key, $value)
    {
        $users = app(UserRepository::class);
        $user = null;

        switch (Str::lower($key)) {
            case 'id':
            case 'uuid':
                $user = $users->findByUUID($value);
                break;
            case 'username':
                $user = $users->findByUsername($value);
                break;
            case 'email':
                $user = $users->findByEmail($value);
                break;
        }

        return $user;
    }
}
