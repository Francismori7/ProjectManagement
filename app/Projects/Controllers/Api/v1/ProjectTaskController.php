<?php

namespace App\Projects\Controllers\Api\v1;

use App\Contracts\Projects\ProjectRepository;
use App\Core\Controllers\Controller;

class ProjectTaskController extends Controller
{
    /**
     * Gets a list of tasks and completed tasks.
     *
     * GET /api/v1/projects/{id}/tasks
     *
     * @param $id
     * @param ProjectRepository $projects
     * @return array
     */
    public function index($id, ProjectRepository $projects)
    {
        $project = $projects->findByUUID($id, ['tasks']);

        return [
            'completedTasks' => $project->completedTasks,
            'tasks' => $project->tasks,
        ];
    }
}