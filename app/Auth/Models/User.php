<?php

namespace App\Auth\Models;

use App\Auth\Traits\HasRoles;
use App\Core\ACL\Models\Permission;
use App\Core\ACL\Traits\HasPermissions;
use App\Core\Models\UUIDBaseModel;
use App\Projects\Models\Invitation;
use App\Projects\Models\Project;
use App\Projects\Models\Task;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use App\Contracts\ACL\HasPermissions as HasPermissionsContract;
use App\Contracts\ACL\HasRoles as HasRolesContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;

/**
 * Class User.
 *
 * @property string $id
 * @property string $username
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $password
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\User whereDeletedAt($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|Project[] $projects
 * @property-read \Illuminate\Database\Eloquent\Collection|Invitation[] $invitations
 * @property-read \Illuminate\Database\Eloquent\Collection|Task[] $tasks
 */
class User extends UUIDBaseModel implements AuthenticatableContract,
    CanResetPasswordContract,
    AuthorizableContract,
    HasPermissionsContract,
    HasRolesContract
{
    use SoftDeletes,
        Authenticatable,
        CanResetPassword,
        Authorizable,
        HasPermissions,
        HasRoles;

    protected $fillable = [
        'username',
        'first_name',
        'last_name',
        'email',
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = ['deleted_at'];

    /**
     * A user can be part of many projects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function projects()
    {
        return $this->belongsToMany(Project::class)->withTimestamps()->withPivot('role');
    }

    /**
     * A user can have many tasks
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class, 'employee_id');
    }

    /**
     * A user can host many invitations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
