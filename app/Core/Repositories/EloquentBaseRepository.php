<?php

namespace App\Core\Repositories;

use App\Contracts\Core\BaseRepository;
use Illuminate\Database\Eloquent\Model;

class EloquentBaseRepository implements BaseRepository
{
    /**
     * Soft-deletes/removes an entity.
     *
     * @param Model $model The Entity to delete.
     * @return bool|null
     */
    public function delete(Model $model)
    {
        return $model->delete();
    }

    /**
     * Soft-deletes/removes an entity.
     *
     * @param Model $model The Entity to delete.
     * @return bool|null
     */
    public function remove(Model $model)
    {
        return $this->delete($model);
    }

    /**
     * Creates and saves an Entity to the database.
     *
     * @param Model $model
     * @return Model
     */
    public function create(Model $model)
    {
        $model->save();
        return $model;
    }

    /**
     * Saves a Entity to the database.
     *
     * @param Model $model
     * @return Model
     */
    public function save(Model $model)
    {
        $model->save();
        return $model;
    }

    /**
     * Restores the soft-deleted model.
     *
     * @param Model $model
     * @return bool|null Success restoring the model.
     */
    public function restore(Model $model)
    {
        if (method_exists($model, "trashed") && !$model->trashed()) {
            return $model->restore();
        }
        return false;
    }
}
