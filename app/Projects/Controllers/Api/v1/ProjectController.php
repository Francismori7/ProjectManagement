<?php

namespace App\Projects\Controllers\Api\v1;

use App\Auth\Models\User;
use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\CreateProjectRequest;
use App\Projects\Http\Requests\DeleteProjectRequest;
use App\Projects\Http\Requests\RestoreProjectRequest;
use App\Projects\Jobs\CreateNewProject;
use App\Projects\Jobs\DeleteProject;
use App\Projects\Jobs\RestoreProject;
use App\Projects\Models\Project;
use Auth;

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

        $this->middleware('jwt.auth');
        $this->middleware('jwt.refresh');
    }

    /**
     * Returns a list of all projects.
     *
     * GET /api/v1/projects
     *
     * @return Project[]|\Illuminate\Database\Eloquent\Collection
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
     * @return Project|null
     */
    public function show($id)
    {
        return $this->projects->findByUUID($id, ['users', 'invitations', 'tasks']);
    }

    /**
     * Creates a new project.
     *
     * POST /api/v1/projects
     *
     * @param CreateProjectRequest $request
     * @return Project
     */
    public function store(CreateProjectRequest $request)
    {
        return $this->dispatch(
            new CreateNewProject($request->all(), $request->user())
        );
    }

    /**
     * Deletes a project.
     *
     * DELETE /api/v1/projects/{id}
     *
     * @param DeleteProjectRequest $request
     * @return Project
     */
    public function destroy($id, DeleteProjectRequest $request)
    {
        $project = $this->projects->findByUUID($id);

        return $this->dispatch(
            new DeleteProject($project)
        );
    }

    /**
     * Deletes a project.
     *
     * GET /api/v1/projects/{id}/restore
     *
     * @param RestoreProjectRequest $request
     * @return Project
     */
    public function restore($id, RestoreProjectRequest $request)
    {
        /** @var Project $project */
        $project = Project::withTrashed()->where('id', $id)->first();

        return $this->dispatch(
            new RestoreProject($project)
        );
    }
}