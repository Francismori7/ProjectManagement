<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\CreateProjectRequest;
use App\Projects\Http\Requests\DeleteProjectRequest;
use App\Projects\Http\Requests\UpdateProjectRequest;
use App\Projects\Jobs\CreateNewProject;
use App\Projects\Jobs\DeleteProject;
use App\Projects\Jobs\UpdateProject;
use App\Projects\Models\Project;

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
     * GET /api/v1/projects/{project}
     *
     * @param $project
     * @return Project|null
     */
    public function show($project)
    {
        return $this->projects->findByUUID($project, ['users', 'invitations', 'tasks']);
    }

    /**
     * Creates a new project.
     *
     * POST /api/v1/projects (name, description, due_at)
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
     * DELETE /api/v1/projects/{project}
     *
     * @param DeleteProjectRequest $request
     * @return Project
     */
    public function destroy($project, DeleteProjectRequest $request)
    {
        $project = $this->projects->findByUUID($project);

        return $this->dispatch(
            new DeleteProject($project)
        );
    }

    /**
     * Updates the project's data.
     *
     * PATCH /api/v1/projects/{project} (name, description, due_at)
     *
     * @param $project
     * @param UpdateProjectRequest $request
     * @return mixed
     */
    public function update($project, UpdateProjectRequest $request)
    {
        $project = $this->projects->findByUUID($project);

        return $this->dispatch(
            new UpdateProject($project, $request->all())
        );
    }

//    TODO: Add comments
//    /**
//     * Gets a list of comments.
//     *
//     * GET /api/v1/projects/{project}/comments
//     *
//     * @param $project
//     * @param ProjectRepository $projects
//     * @return array
//     */
//    public function comments($project, ProjectRepository $projects)
//    {
//        $project = $projects->findByUUID($project, ['comments']);
//
//        return [
//            'comments' => $project->comments,
//        ];
//    }
}