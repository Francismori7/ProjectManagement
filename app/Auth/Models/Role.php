<?php

namespace App\Auth\Models;

use App\Core\ACL\Models\Permission;
use App\Core\Models\BaseEntity;
use App\Core\ACL\Traits\HasPermissions;
use App\Contracts\ACL\HasPermissions as HasPermissionsContract;

/**
 * Class Role.
 *
 * @property integer $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|Permission[] $permissions
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\Role whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Auth\Models\Role whereName($value)
 */
class Role extends BaseEntity implements HasPermissionsContract
{
    use HasPermissions;

    public $timestamps = false;

    /**
     * A Role can have many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * A Role can have many permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
}
