<?php

namespace App\Contracts\Core;

use Illuminate\Database\Eloquent\Model;

interface BaseRepository
{
    /**
     * Saves a model to the database.
     *
     * @param Model $model
     * @return Model
     */
    public function save(Model $model);

    /**
     * Creates and saves an Model to the database.
     *
     * @param Model $model
     * @return Model
     */
    public function create(Model $model);

    /**
     * Soft-deletes/removes a User.
     *
     * @param Model $model The BaseEntity to delete.
     * @return bool|null
     */
    public function delete(Model $model);

    /**
     * Soft-deletes/removes a User.
     *
     * @param Model $model The BaseEntity to delete.
     * @return bool|null
     */
    public function remove(Model $model);

    /**
     * Restores the soft-deleted model.
     *
     * @param Model $model
     * @return bool|null Success restoring the model.
     */
    public function restore(Model $model);
}
