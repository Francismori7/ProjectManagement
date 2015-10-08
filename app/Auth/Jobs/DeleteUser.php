<?php

namespace App\Auth\Jobs;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class DeleteUser extends Job implements SelfHandling
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
        $users->delete($this->user);
        $users->flush();
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