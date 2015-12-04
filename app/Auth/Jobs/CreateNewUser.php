<?php

namespace App\Auth\Jobs;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateNewUser extends Job implements SelfHandling
{
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     *
     * @param array|User $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @param UserRepository $users
     *
     * @return User
     */
    public function handle(UserRepository $users)
    {
        $user = new User($this->data);
        $user->password = bcrypt($this->data['password']);

        $users->save($user)->flush();

        return $user;
    }
}
