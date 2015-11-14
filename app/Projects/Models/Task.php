<?php

namespace App\Projects\Models;

use App\Auth\Models\User;
use App\Core\Models\UUIDBaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task.
 */
class Task extends UUIDBaseEntity
{
    use SoftDeletes;

    protected $dates = ['due_at', 'deleted_at'];

    /**
     * A task is part of a project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * A task needs an assignee.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function employee()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * A task needs a host who creates the task.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function host()
    {
        return $this->belongsTo(User::class);
    }
}