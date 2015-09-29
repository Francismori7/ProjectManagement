<?php

namespace App\Jobs\Users;

use App\Jobs\Job;
use App\Repositories\Contracts\UserRepository;
use App\User;
use Illuminate\Contracts\Bus\SelfHandling;

class CreateNewUser extends Job implements SelfHandling
{
    /**
     * @var array
     */
    private $data;

    /**
     * Create a new job instance.
     * @param array|User $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     * @param UserRepository $users
     * @return User
     */
    public function handle(UserRepository $users)
    {
        if($this->data instanceof User) {
            $user = $this->data;
        }
        else {
            $user = (new User)->setUserName($this->data['username'])
                ->setFirstName($this->data['first_name'])
                ->setLastName($this->data['last_name'])
                ->setEmail($this->data['email'])
                ->setPassword($this->data['password']);
        }

        $users->save($user);
        $users->flush();

        return $user;
    }
}