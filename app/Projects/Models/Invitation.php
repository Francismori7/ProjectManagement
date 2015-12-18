<?php

namespace App\Projects\Models;

use App\Auth\Models\User;
use App\Core\Models\UUIDBaseModel;

/**
 * Class Invitation.
 *
 * @property string $id
 * @property string $project_id
 * @property string $host_id
 * @property string $email
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read Project $project
 * @property-read User $host
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Invitation whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Invitation whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Invitation whereHostId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Invitation whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Invitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Invitation whereUpdatedAt($value)
 */
class Invitation extends UUIDBaseModel
{
    protected $fillable = [
        'email',
        'host_id',
        'project_id',
    ];

    /**
     * An invitation belongs to a project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * An invitation was created by a specific user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function host()
    {
        return $this->belongsTo(User::class);
    }
}
