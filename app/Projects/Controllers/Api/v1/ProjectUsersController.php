<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;

class ProjectUsersController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * ProjectController constructor.
     *
     * @param ProjectRepository $projects
     */
    public function __construct(ProjectRepository $projects)
    {
        $this->projects = $projects;

        //$this->middleware('jwt.auth');
        //$this->middleware('jwt.refresh');
    }

    /**
     * Returns the project's users.
     *
     * GET /api/v1/projects/{id}/users
     *
     * @param $id
     * @return \App\Projects\Models\Project|null
     */
    public function show($id)
    {
        return $this->projects->findByUUID($id)->users;
    }
}