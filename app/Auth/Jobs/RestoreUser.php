<?php

namespace App\Auth\Jobs;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Jobs\Job;

class RestoreUser extends Job
{
    /**
     * @var User
     */
    private $user;

    /**
     * Execute the job.
     *
     * @param UserRepository $users
     *
     * @return User
     */
    public function handle(UserRepository $users)
    {
        return $users->restore($this->user);
    }

    /**
     * Create a new job instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
