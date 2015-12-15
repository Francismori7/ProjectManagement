<?php

namespace App\Projects\Controllers\Api\v1;

use App\Auth\Models\User;
use App\Contracts\Auth\UserRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\DemoteUserRequest;
use App\Projects\Http\Requests\InviteUserRequest;
use App\Projects\Http\Requests\PromoteUserRequest;
use App\Projects\Jobs\DemoteUser;
use App\Projects\Jobs\InviteUser;
use App\Projects\Jobs\PromoteUser;
use App\Projects\Models\Project;

class ProjectUserController extends Controller
{
    /**
     * @var UserRepository
     */
    protected $users;
    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * ProjectUserController constructor.
     *
     * @param UserRepository $users
     * @param ProjectRepository $projects
     */
    public function __construct(UserRepository $users, ProjectRepository $projects)
    {
        $this->users = $users;
        $this->projects = $projects;

        $this->middleware('jwt.auth');
        $this->middleware('jwt.refresh', ['only' => 'store']);
    }

    /**
     * Gets a list of users and leaders.
     *
     * GET /api/v1/projects/{project}/users
     *
     * @param Project $project
     * @return array
     */
    public function index(Project $project)
    {
        $project->load('users');

        return [
            'leaders' => $project->leaders,
            'users' => $project->users,
        ];
    }

    /**
     * Promotes a user to leader of the project.
     *
     * PATCH /api/v1/projects/{project}/users/{user}/promote
     *
     * @param Project $project
     * @param User $user
     * @param PromoteUserRequest $request
     * @return array|mixed
     */
    public function promote(Project $project, User $user, PromoteUserRequest $request)
    {
        return $this->dispatch(new PromoteUser(
            $project, $user
        ));
    }

    /**
     * Demotes a user from the leader role for the project.
     *
     * PATCH /api/v1/projects/{project}/users/{user}/promote
     *
     * @param Project $project
     * @param User $user
     * @param DemoteUserRequest $request
     * @return array|mixed
     */
    public function demote(Project $project, User $user, DemoteUserRequest $request)
    {
        return $this->dispatch(new DemoteUser(
            $project, $user
        ));
    }

    /**
     * Invites a user (by email) to the project.
     *
     * POST /api/v1/projects/{project}/users/invite (email)
     *
     * @param Project $project
     * @param InviteUserRequest $request
     * @return mixed
     */
    public function invite(Project $project, InviteUserRequest $request)
    {
        return $this->dispatch(new InviteUser(
            $project, $request->user(), $request->input('email')
        ));
    }
}
