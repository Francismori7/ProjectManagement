<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\CompleteTaskRequest;
use App\Projects\Http\Requests\CreateTaskRequest;
use App\Projects\Http\Requests\UpdateTaskRequest;
use App\Projects\Jobs\CreateNewTask;
use App\Projects\Jobs\UpdateTask;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectRepository
     */
    protected $projects;

    /**
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * ProjectTaskController constructor.
     *
     * @param ProjectRepository $projects
     * @param TaskRepository $tasks
     */
    public function __construct(ProjectRepository $projects, TaskRepository $tasks)
    {
        $this->projects = $projects;

        $this->middleware('jwt.auth');
        $this->middleware('jwt.refresh');
        $this->tasks = $tasks;
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
        if (!auth()->user()->projects->contains('id', $project)) {
            return response()->json(['not_in_project'], 403);
        }

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

    /**
     * Updates a task.
     *
     * PATCH /api/v1/projects/{project}/tasks/{task} (task, employee_id, completed, due_at)
     *
     * @param $project
     * @param $task
     * @param UpdateTaskRequest $request
     * @return array
     */
    public function update($project, $task, UpdateTaskRequest $request)
    {
        $task = $this->tasks->findByUUID($task);

        return $this->dispatch(
            new UpdateTask($task, $request->all())
        );
    }

    /**
     * Completes/uncompletes a task.
     *
     * PATCH /api/v1/projects/{project}/tasks/{task}/complete
     *
     * @param $project
     * @param $task
     * @param CompleteTaskRequest $request
     * @return array
     */
    public function complete($project, $task, CompleteTaskRequest $request)
    {
        $task = $this->tasks->findByUUID($task);

        return $this->dispatch(
            new UpdateTask($task, ['completed' => !$task->completed])
        );
    }
}