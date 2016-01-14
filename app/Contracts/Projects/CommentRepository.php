<?php

namespace App\Contracts\Projects;

use App\Auth\Models\User;
use App\Contracts\Core\BaseRepository;
use App\Projects\Models\Project;
use App\Projects\Models\Comment;
use Illuminate\Database\Eloquent\Collection;

interface CommentRepository extends BaseRepository
{
    /**
     * Returns all the Tasks.
     *
     * @return Collection All Comments.
     */
    public function findAll();

    /**
     * Returns all the Comments.
     *
     * @param array $relations
     * @return Collection All comments.
     */
    public function all(array $relations = []);

    /**
     * Find a comment entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Comment|null The comment.
     */
    public function find($uuid, array $relations = []);

    /**
     * Find a comment entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Comment|null The comment.
     */
    public function findByUUID($uuid, array $relations = []);

    /**
     * Returns the comments for an employee.
     *
     * @param User $user The user to look for in the database.
     * @param array $relations
     * @return Collection Comments by the user.
     */
    public function findByUser(User $user, array $relations = []);

    /**
     * Returns the comments for a project
     *
     * @param Project $project The project to look for in the database.
     * @param array $relations
     * @return Collection Comments for the project.
     */
    public function findByProject(Project $project, array $relations = []);
}
