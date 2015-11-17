<?php

namespace App\Projects\Models;

use App\Auth\Models\User;
use App\Core\Models\UUIDBaseEntity;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Project.
 *
 * @property string $id
 * @property string $name
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Invitation[] $invitations
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereDeletedAt($value)
 * @property string $created_by
 * @property string $due_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Task[] $tasks
 * @property-read mixed $completed_tasks
 * @property-read mixed $leaders
 * @property-read User $creator
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereCreatedBy($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Project whereDueAt($value)
 */
class Project extends UUIDBaseEntity
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
    ];

    protected $dates = ['deleted_at'];

    protected $appends = ['leaders', 'completedTasks'];

    /**
     * A Project can have many tasks.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Returns a list of completed tasks.
     *
     * @return mixed
     */
    public function getCompletedTasksAttribute() {
        return $this->tasks->where('completed', 1);
    }

    /**
     * A Project can have many leaders.
     *
     * @return mixed
     */
    public function getLeadersAttribute()
    {
        return $this->users->where('pivot.role', 'leader');
    }

    /**
     * A Project can have many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('role');
    }

    /**
     * A Project can have many invitations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    /**
     * A Project was created by one leader (protected from demotion and more).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

//    TODO: Add comments
//    /**
//     * A Project can have many comments to it.
//     *
//     * @return \Illuminate\Database\Eloquent\Relations\HasMany
//     */
//    public function comments() {
//        return $this->hasMany(Comment::class);
//    }
}
