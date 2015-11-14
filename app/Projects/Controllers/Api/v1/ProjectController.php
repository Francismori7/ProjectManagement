<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;

class ProjectController extends Controller
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
     * Returns a list of all projects.
     *
     * GET /api/v1/projects
     *
     * @return \App\Projects\Models\Project[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return $this->projects->all();
    }

    /**
     * Returns the project's data.
     *
     * GET /api/v1/projects/{id}
     *
     * @param $id
     * @return \App\Projects\Models\Project|null
     */
    public function show($id)
    {
        return $this->projects->findByUUID($id, ['users', 'invitations', 'tasks']);
    }
}