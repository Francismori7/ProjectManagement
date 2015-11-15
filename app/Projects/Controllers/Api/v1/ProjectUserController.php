<?php

namespace App\Projects\Controllers\Api\v1;

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
        $this->middleware('jwt.refresh');
    }

    /**
     * Gets a list of users and leaders.
     *
     * GET /api/v1/projects/{project}/users
     *
     * @param $project
     * @return array
     */
    public function index($project)
    {
        $project = $this->projects->findByUUID($project, ['users']);

        return [
            'leaders' => $project->leaders,
            'users' => $project->users,
        ];
    }

    /**
     * Promotes a user to leader.
     *
     * PATCH /api/v1/projects/{project}/users/{user}/promote
     *
     * @param $project
     * @param $user
     * @param PromoteUserRequest $request
     * @return array|mixed
     */
    public function promote($project, $user, PromoteUserRequest $request)
    {
        /** @var Project $project */
        $project = $this->projects->findByUUID($project, ['users']);
        $user = $this->users->findByUUID($user);

        return $this->dispatch(new PromoteUser(
            $project, $user
        ));
    }

    /**
     * Demotes a user from leader.
     *
     * PATCH /api/v1/projects/{project}/users/{user}/promote
     *
     * @param $project
     * @param $user
     * @param DemoteUserRequest $request
     * @return array|mixed
     */
    public function demote($project, $user, DemoteUserRequest $request)
    {
        /** @var Project $project */
        $project = $this->projects->findByUUID($project, ['users']);
        $user = $this->users->findByUUID($user);

        return $this->dispatch(new DemoteUser(
            $project, $user
        ));
    }

    /**
     * Invites a user (by email) to the project.
     *
     * POST /api/v1/projects/{project}/users/invite (email)
     *
     * @param $project
     * @param InviteUserRequest $request
     * @return mixed
     */
    public function invite($project, InviteUserRequest $request)
    {
        /** @var Project $project */
        $project = $this->projects->findByUUID($project);

        return $this->dispatch(new InviteUser(
            $project, $request->user(), $request->input('email')
        ));
    }
}