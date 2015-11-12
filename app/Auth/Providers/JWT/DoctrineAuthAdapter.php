<?php

namespace App\Auth\Providers\JWT;

use App\Contracts\Auth\UserRepository;
use Tymon\JWTAuth\Providers\Auth\AuthInterface;
use Tymon\JWTAuth\Providers\Auth\IlluminateAuthAdapter;

class DoctrineAuthAdapter extends IlluminateAuthAdapter implements AuthInterface
{
    /**
     * Get the currently authenticated user
     *
     * @return mixed
     */
    public function user()
    {
        $users = app(UserRepository::class);

        return $users->findByUUID(
            $this->auth->user()->getId(),
            ['p' => 'permissions', 'r' => 'roles']
        );
    }
}
