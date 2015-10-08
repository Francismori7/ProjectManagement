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
     * Execute the job.
     *
     * @param UserRepository $users
     *
     * @return User
     */
    public function handle(UserRepository $users)
    {
        $user = $this->data instanceof User ?
            $this->data :
            (new User)->setUsername($this->data['username'])
                ->setFirstName($this->data['first_name'])
                ->setLastName($this->data['last_name'])
                ->setEmail($this->data['email'])
                ->setPassword($this->data['password']);

        $users->save($user);
        $users->flush();

        return $user;
    }

    /**
     * Create a new job instance.
     *
     * @param array|User $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }
}
