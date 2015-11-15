<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Auth\UserRepository;
use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\DemoteUserRequest;
use App\Projects\Http\Requests\PromoteUserRequest;
use App\Projects\Jobs\DemoteUser;
use App\Projects\Jobs\PromoteUser;
use App\Projects\Models\Project;

class ProjectUserController extends Controller
{
    /**
     * Gets a list of users and leaders.
     *
     * GET /api/v1/projects/{id}/users
     *
     * @param $id
     * @param ProjectRepository $projects
     * @return array
     */
    public function index($id, ProjectRepository $projects)
    {
        $project = $projects->findByUUID($id, ['users']);

        return [
            'leaders' => $project->leaders,
            'users' => $project->users,
        ];
    }

    /**
     * Promotes a user to leader.
     *
     * PATCH /api/v1/projects/{id}/users/promote (user_id)
     *
     * @param $id
     * @param PromoteUserRequest $request
     * @param UserRepository $users
     * @param ProjectRepository $projects
     * @return array|mixed
     */
    public function promote($id, PromoteUserRequest $request, UserRepository $users, ProjectRepository $projects)
    {
        /** @var Project $project */
        $project = $projects->findByUUID($id, ['users']);
        $user = $users->findByUUID($request->input('user_id'));

        if (!$project->users->contains('id', $user->id)) {
            return ['user_not_in_project_users'];
        }

        return $this->dispatch(new PromoteUser(
            $project, $user
        ));
    }

    /**
     * Demotes a user from leader.
     *
     * PATCH /api/v1/projects/{id}/users/promote (user_id)
     *
     * @param $id
     * @param DemoteUserRequest $request
     * @param UserRepository $users
     * @param ProjectRepository $projects
     * @return array|mixed
     */
    public function demote($id, DemoteUserRequest $request, UserRepository $users, ProjectRepository $projects)
    {
        /** @var Project $project */
        $project = $projects->findByUUID($id, ['users']);
        $user = $users->findByUUID($request->input('user_id'));

        if (!$project->leader->contains('id', $user->id)) {
            return ['user_not_in_project_leaders'];
        }

        return $this->dispatch(new DemoteUser(
            $project, $user
        ));
    }
}