<?php

namespace App\Projects\Repositories;

use App\Auth\Models\User;
use App\Contracts\Projects\ProjectRepository;
use App\Contracts\Projects\TaskRepository;
use App\Core\Repositories\EloquentBaseRepository;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class EloquentTaskRepository extends EloquentBaseRepository implements TaskRepository
{
    /**
     * Returns all the Tasks.
     *
     * @return Collection All tasks.
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Tasks.
     *
     * @param array $relations
     * @return Collection All tasks.
     */
    public function all(array $relations = [])
    {
        return Task::with($relations)->get();
    }

    /**
     * Find a task entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Task|null The task.
     */
    public function find($uuid, array $relations = [])
    {
        return $this->findByUUID($uuid, $relations);
    }

    /**
     * Find a task entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Task|null The task.
     */
    public function findByUUID($uuid, array $relations = [])
    {
        return Task::with($relations)->where('id', $uuid)->first();
    }

    /**
     * Returns the tasks for an employee.
     *
     * @param User $employee The user to look for in the database.
     * @param array $relations
     * @return Collection Tasks for the employee.
     */
    public function findByEmployee(User $employee, array $relations = [])
    {
        return Task::with($relations)->where('employee_id', $employee->id)->get();
    }

    /**
     * Returns the tasks created by an host.
     *
     * @param User $host The user to look for in the database.
     * @param array $relations
     * @return Collection Tasks for the host.
     */
    public function findByHost(User $host, array $relations = [])
    {
        return Task::with($relations)->where('host_id', $host->id)->get();
    }

    /**
     * Returns the tasks for a project
     *
     * @param Project $project The project to look for in the database.
     * @param array $relations
     * @return Collection Tasks for the project.
     */
    public function findByProject(Project $project, array $relations = [])
    {
        return Task::with($relations)->where('project_id', $project->id)->get();
    }
}
