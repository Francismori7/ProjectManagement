<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\CreateProjectRequest;
use App\Projects\Http\Requests\DeleteProjectRequest;
use App\Projects\Http\Requests\RestoreProjectRequest;
use App\Projects\Http\Requests\UpdateProjectRequest;
use App\Projects\Jobs\CreateNewProject;
use App\Projects\Jobs\DeleteProject;
use App\Projects\Jobs\RestoreProject;
use App\Projects\Jobs\UpdateProject;
use App\Projects\Models\Project;
use Illuminate\Http\Request;

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
     * @return \App\Projects\Models\Project[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        /** @var User $user */
        $user = auth()->user();

        return $user->projects;
    }

    /**
     * Returns the project's data.
     *
     * GET /api/v1/projects/{project}
     *
     * @param Project $project
     * @return Project|null
     */
    public function show(Project $project)
    {
        /** @var User $user */
        $user = auth()->user();

        if (! $user->projects->contains('id', $project->id)) {
            return response()->json(['not_in_project'], 403);
        }

        return $project->load(['users', 'invitations', 'tasks']);
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
     * @param Project $project
     * @param DeleteProjectRequest $request
     * @return Project
     */
    public function destroy(Project $project, DeleteProjectRequest $request)
    {
        return $this->dispatch(
            new DeleteProject($project)
        );
    }

    /**
     * Restores a project.
     *
     * PATCH /api/v1/projects/{project}/restore
     *
     * @param Project $project
     * @param RestoreProjectRequest $request
     * @return Project
     */
    public function restore(Project $project, RestoreProjectRequest $request)
    {
        return $this->dispatch(
            new RestoreProject($project)
        );
    }

    /**
     * Updates the project's data.
     *
     * PATCH /api/v1/projects/{project} (name, description, due_at)
     *
     * @param Project $project
     * @param UpdateProjectRequest $request
     * @return mixed
     */
    public function update(Project $project, UpdateProjectRequest $request)
    {
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
//     * @param Project $project
//     * @param ProjectRepository Project $projects
//     * @return array
//     */
//    public function comments(Project $project, ProjectRepository Project $projects)
//    {
//        Project $project = Project $projects->findByUUID(Project $project, ['comments']);
//
//        return [
//            'comments' => Project $project->comments,
//        ];
//    }
}
