<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Controllers\Controller;
use App\Projects\Http\Requests\CompleteTaskRequest;
use App\Projects\Http\Requests\CreateTaskRequest;
use App\Projects\Http\Requests\DeleteTaskRequest;
use App\Projects\Http\Requests\RestoreTaskRequest;
use App\Projects\Http\Requests\UpdateTaskRequest;
use App\Projects\Jobs\CreateNewTask;
use App\Projects\Jobs\DeleteTask;
use App\Projects\Jobs\RestoreTask;
use App\Projects\Jobs\UpdateTask;
use App\Projects\Models\Project;
use App\Projects\Models\Task;

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
     * Gets a list of tasks and completed tasks.
     *
     * GET /api/v1/projects/{project}/tasks
     *
     * @param Project $project
     * @return array
     */
    public function index(Project $project)
    {
        if (! auth()->user()->projects->contains('id', $project->id)) {
            return response()->json(['not_in_project'], 403);
        }

        $project->load('tasks');

        return [
            'completedTasks' => $project->completedTasks,
            'tasks' => $project->tasks,
        ];
    }

    /**
     * Deletes a task.
     *
     * DELETE /api/v1/projects/{project}/tasks/{task}
     *
     * @param Project $project
     * @param Task $task
     * @param DeleteTaskRequest $request
     * @return array
     */
    public function destroy(Project $project, Task $task, DeleteTaskRequest $request)
    {
        return $this->dispatch(new DeleteTask(
            $task
        ));
    }

    /**
     * Restores a task.
     *
     * PATCH /api/v1/projects/{project}/tasks/{task}/restore
     *
     * @param $project
     * @param $task
     * @param RestoreTaskRequest $request
     * @return array
     */
    public function restore(Project $project, Task $task, RestoreTaskRequest $request)
    {
        return $this->dispatch(new RestoreTask(
            $task
        ));
    }

    /**
     * Creates a new task for the given project.
     *
     * POST /api/v1/projects/{project}/tasks (task, employee_id, completed, due_at)
     *
     * @param Project $project
     * @param CreateTaskRequest $request
     * @return array
     */
    public function store(Project $project, CreateTaskRequest $request)
    {
        return $this->dispatch(
            new CreateNewTask($request->all(), $project, $request->user())
        );
    }

    /**
     * Updates a task.
     *
     * PATCH /api/v1/projects/{project}/tasks/{task} (task, employee_id, completed, due_at)
     *
     * @param Project $project
     * @param Task $task
     * @param UpdateTaskRequest $request
     * @return array
     */
    public function update(Project $project, Task $task, UpdateTaskRequest $request)
    {
        return $this->dispatch(
            new UpdateTask($task, $request->all())
        );
    }

    /**
     * Completes/uncompletes a task.
     *
     * PATCH /api/v1/projects/{project}/tasks/{task}/complete
     *
     * @param Project $project
     * @param Task $task
     * @param CompleteTaskRequest $request
     * @return array
     */
    public function complete(Project $project, Task $task, CompleteTaskRequest $request)
    {
        return $this->dispatch(
            new UpdateTask($task, ['completed' => ! $task->completed])
        );
    }

    /**
     * ProjectTaskController constructor.
     *
     * @param ProjectRepository $projects
     * @param TaskRepository $tasks
     */
    public function __construct(ProjectRepository $projects, TaskRepository $tasks)
    {
        $this->middleware('jwt.auth');
        $this->middleware('jwt.refresh');
        $this->tasks = $tasks;
    }
}