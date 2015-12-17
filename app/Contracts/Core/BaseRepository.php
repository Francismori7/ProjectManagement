<?php

namespace App\Contracts\Core;

use App\Core\Models\Entity;

interface BaseRepository
{
    /**
     * Saves a Entity to the database.
     *
     * @param Entity $entity
     * @return Entity
     */
    public function save(Entity $entity);

    /**
     * Creates and saves an Entity to the database.
     *
     * @param Entity $entity
     * @return Entity
     */
    public function create(Entity $entity);

    /**
     * Soft-deletes/removes a User.
     *
     * @param Entity $entity The BaseEntity to delete.
     * @return bool|null
     */
    public function delete(Entity $entity);

    /**
     * Soft-deletes/removes a User.
     *
     * @param Entity $entity The BaseEntity to delete.
     * @return bool|null
     */
    public function remove(Entity $entity);

    /**
     * Restores the soft-deleted model.
     *
     * @param Model $model
     * @return bool|null Success restoring the model.
     */
    public function restore(Model $model);
}
