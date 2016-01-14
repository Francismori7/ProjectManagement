<?php

namespace App\Projects\Repositories;

use App\Auth\Models\User;
use App\Contracts\Projects\CommentRepository;
use App\Core\Repositories\EloquentBaseRepository;
use App\Projects\Models\Comment;
use App\Projects\Models\Project;
use Illuminate\Database\Eloquent\Collection;

class EloquentCommentRepository extends EloquentBaseRepository implements CommentRepository
{
    /**
     * Returns all the Tasks.
     *
     * @return Collection All Comments.
     */
    public function findAll()
    {
        return $this->all();
    }

    /**
     * Returns all the Comments.
     *
     * @param array $relations
     * @return Collection All comments.
     */
    public function all(array $relations = [])
    {
        return Comment::with($relations)->get();
    }

    /**
     * Find a comment entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Comment|null The comment.
     */
    public function find($uuid, array $relations = [])
    {
        return $this->findByUUID($uuid, $relations);
    }

    /**
     * Find a comment entity by UUID.
     *
     * @param string $uuid The identifier to look for in the database.
     * @param array $relations
     * @return Comment|null The comment.
     */
    public function findByUUID($uuid, array $relations = [])
    {
        return Comment::with($relations)->where('id', $uuid)->first();
    }

    /**
     * Returns the comments for an employee.
     *
     * @param User $user The user to look for in the database.
     * @param array $relations
     * @return Collection Comments by the user.
     */
    public function findByUser(User $user, array $relations = [])
    {
        return Comment::with($relations)->where('user_id', $user->id)->get();
    }

    /**
     * Returns the comments for a project
     *
     * @param Project $project The project to look for in the database.
     * @param array $relations
     * @return Collection Comments for the project.
     */
    public function findByProject(Project $project, array $relations = [])
    {
        return Comment::with($relations)->where('project_id', $project->id)->get();
    }


}
