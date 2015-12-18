<?php

namespace App\Core\ACL\Models;

use App\Auth\Models\Role;
use App\Auth\Models\User;
use App\Core\Models\BaseModel;

/**
 * Class Permission.
 *
 * @property integer $id
 * @property string $pattern
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @method static \Illuminate\Database\Query\Builder|\App\Core\ACL\Models\Permission whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\ACL\Models\Permission wherePattern($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Core\ACL\Models\Permission whereName($value)
 */
class Permission extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'pattern',
        'name',
    ];

    /**
     * A Permission can belong to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * A Permission can belong to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
