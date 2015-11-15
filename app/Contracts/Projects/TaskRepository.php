<?php

namespace App\Contracts\Projects;

use App\Auth\Models\User;
use App\Contracts\Core\BaseRepository;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Illuminate\Database\Eloquent\Collection;

interface TaskRepository extends BaseRepository
{
    /**
     * Returns all the Tasks.
     *
     * @return Collection All tasks.
     */
    public function findAll();

    /**
     * Returns all the Tasks.
     *
     * @param array $relations
     * @return Collection All tasks.
     */
    public function all(array $relations = []);

    /**
     * Find a task entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Task|null The task.
     */
    public function find($uuid, array $relations = []);

    /**
     * Find a task entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Task|null The task.
     */
    public function findByUUID($uuid, array $relations = []);

    /**
     * Returns the tasks for an employee.
     *
     * @param User $employee The user to look for in the database.
     * @param array $relations
     * @return Collection Tasks for the employee.
     */
    public function findByEmployee(User $employee, array $relations = []);

    /**
     * Returns the tasks created by an host.
     *
     * @param User $host The user to look for in the database.
     * @param array $relations
     * @return Collection Tasks for the host.
     */
    public function findByHost(User $host, array $relations = []);

    /**
     * Returns the tasks for a project
     *
     * @param Project $project The project to look for in the database.
     * @param array $relations
     * @return Collection Tasks for the project.
     */
    public function findByProject(Project $project, array $relations = []);
}
