<?php

namespace App\Core\ACL\Models;

use App\Auth\Models\Role;
use App\Auth\Models\User;
use App\Core\Models\BaseEntity;

/**
 * Class Permission.
 */
class Permission extends BaseEntity
{
    public $timestamps = false;

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
