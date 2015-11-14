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

    /**
     * Execute the job.
     *
     * @param UserRepository $users
     *
     * @return User
     */
    public function handle(UserRepository $users)
    {
        $this->user->fill($this->data);

        if (isset($this->data['password'])) {
            $this->user->password = bcrypt($this->data['password']);
        }

        $users->save($this->user)->flush();

        return $this->user;
    }
}
