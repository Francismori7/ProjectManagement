<?php

namespace App\Auth\Jobs;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Core\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class UpdateUser extends Job implements SelfHandling
{
    /**
     * @var User
     */
    private $user;
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
        $this->user->setUsername($this->data['username'])
            ->setFirstName($this->data['first_name'])
            ->setLastName($this->data['last_name'])
            ->setEmail($this->data['email'])
            ->setPassword($this->data['password']);

        $users->save($this->user);
        $users->flush();

        return $this->user;
    }

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param array $data
     */
    public function __construct(User $user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }
}
