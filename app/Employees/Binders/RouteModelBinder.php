<?php

namespace App\Employees\Binders;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Contracts\Projects\InvitationRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Contracts\Projects\TaskRepository;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RouteModelBinder
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * RouteModelBinder constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Binds the "employee" key to the following implementation.
     *
     * @param $id
     * @return User|null
     */
    public function employee($id)
    {
        $employee = $this->userRepository->findByUUID($id);

        if (!$employee) {
            throw (new ModelNotFoundException)->setModel(User::class);
        }
        return $employee;
    }
}