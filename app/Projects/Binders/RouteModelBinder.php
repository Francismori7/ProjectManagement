<?php

namespace App\Projects\Binders;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Contracts\Projects\InvitationRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Contracts\Projects\TaskRepository;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Route;

class RouteModelBinder
{
    /**
     * @var InvitationRepository
     */
    private $invitationRepository;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var TaskRepository
     */
    private $taskRepository;
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * RouteModelBinder constructor.
     *
     * @param InvitationRepository $invitationRepository
     * @param ProjectRepository $projectRepository
     * @param TaskRepository $taskRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        InvitationRepository $invitationRepository,
        ProjectRepository $projectRepository,
        TaskRepository $taskRepository,
        UserRepository $userRepository
    ) {
        $this->invitationRepository = $invitationRepository;
        $this->projectRepository = $projectRepository;
        $this->taskRepository = $taskRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Binds the "invitation" key to the following implementation.
     *
     * @param $id
     * @return Invitation|null
     */
    public function invitation($id)
    {
        $invitation = $this->invitationRepository->findByUUID($id);

        if (!$invitation) {
            throw (new ModelNotFoundException)->setModel(Invitation::class);
        }
        return $invitation;
    }

    /**
     * Binds the "project" key to the following implementation.
     *
     * @param $id
     * @return Project|null
     */
    public function project($id)
    {
        $project = $this->projectRepository->findByUUID($id);

        if (!$project) {
            throw (new ModelNotFoundException)->setModel(Project::class);
        }
        return $project;
    }

    /**
     * Binds the "task" key to the following implementation.
     *
     * @param $id
     * @return Task|null
     */
    public function task($id)
    {
        $task = $this->taskRepository->findByUUID($id);

        if (!$task) {
            throw (new ModelNotFoundException)->setModel(Task::class);
        }
        return $task;
    }

    /**
     * Binds the "user" key to the following implementation.
     *
     * @param $id
     * @return Task|null
     */
    public function user($id)
    {
        $user = $this->userRepository->findByUUID($id);

        if (!$user) {
            throw (new ModelNotFoundException)->setModel(User::class);
        }
        return $user;
    }
}
