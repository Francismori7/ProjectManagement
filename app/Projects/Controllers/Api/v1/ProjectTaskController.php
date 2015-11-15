<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\CreateTaskRequest;
use App\Projects\Jobs\CreateNewTask;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * ProjectTaskController constructor.
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
     * Gets a list of tasks and completed tasks.
     *
     * GET /api/v1/projects/{project}/tasks
     *
     * @param $project
     * @return array
     */
    public function index($project)
    {
        $project = $this->projects->findByUUID($project, ['tasks']);

        return [
            'completedTasks' => $project->completedTasks,
            'tasks' => $project->tasks,
        ];
    }

    /**
     * Gets a list of tasks and completed tasks.
     *
     * POST /api/v1/projects/{project}/tasks (task, employee_id, completed, due_at)
     *
     * @param $project
     * @param CreateTaskRequest $request
     * @return array
     */
    public function store($project, CreateTaskRequest $request)
    {
        $project = $this->projects->findByUUID($project);

        return $this->dispatch(
            new CreateNewTask($request->all(), $project, $request->user())
        );
    }
}