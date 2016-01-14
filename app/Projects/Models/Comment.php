<?php

namespace App\Projects\Models;

use App\Auth\Models\User;
use App\Core\Models\UUIDBaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Comment.
 *
 * @property string $id
 * @property string $body
 * @property string $project_id
 * @property string $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read Project $project
 * @property-read User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Comment whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Comment whereBody($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Comment whereProjectId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Comment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Projects\Models\Comment whereDeletedAt($value)
 */
class Comment extends UUIDBaseModel
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'body',
        'user_id',
    ];

    /**
     * A comment is part of a project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * A comment was created by a user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
