<?php

namespace App\Core\Models;

use Uuid;

/**
 * Class BaseEntity
 *
 * @package App\Core\Models
 */
class UUIDBaseModel extends BaseModel
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * Attach to the 'creating' Model Event to provide a UUID
         * for the `id` field (provided by $model->getKeyName())
         */
        static::creating(function (UUIDBaseModel $model) {
            $model->{$model->getKeyName()} = (string)$model->generateNewId();
        });
    }

    /**
     * Get a new version 4 (random) UUID.
     *
     * @return string
     */
    public function generateNewId()
    {
        return Uuid::generate(4);
    }
}
