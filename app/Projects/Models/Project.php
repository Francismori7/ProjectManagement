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
 */
class Project extends UUIDBaseEntity
{
    use SoftDeletes;

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
     * A Project can have many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withPivot('role');
    }
}
