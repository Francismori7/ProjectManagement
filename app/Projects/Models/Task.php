<?php

namespace App\Projects\Models;

use App\Auth\Models\User;
use App\Core\Models\UUIDBaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Task.
 *
 * @property string $id
 * @property string $task
 * @property string $project_id
 * @property string $employee_id
 * @property string $host_id
 * @property boolean $completed
 * @property \Carbon\Carbon $due_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read Project $project
 * @property-read User $employee
 * @property-read User $host
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereTask($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereEmployeeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereHostId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereCompleted($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereDueAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Task whereDeletedAt($value)
 */
class Task extends UUIDBaseEntity
{
    use SoftDeletes;

    protected $dates = ['due_at', 'deleted_at'];

    protected $fillable = [
        'task',
        'employee_id',
        'completed',
        'due_at',
    ];

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