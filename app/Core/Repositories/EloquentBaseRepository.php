<?php

namespace App\Core\Repositories;

use App\Contracts\Core\BaseRepository;
use App\Core\Models\Entity;

class EloquentBaseRepository implements BaseRepository
{
    /**
     * Soft-deletes/removes an entity.
     *
     * @param Entity $entity The Entity to delete.
     * @return bool|null
     */
    public function delete(Entity $entity)
    {
        return $entity->delete();
    }

    /**
     * Soft-deletes/removes an entity.
     *
     * @param Entity $entity The Entity to delete.
     * @return bool|null
     */
    public function remove(Entity $entity)
    {
        return $this->delete($entity);
    }

    /**
     * Creates and saves an Entity to the database.
     *
     * @param Entity $entity
     * @return Entity
     */
    public function create(Entity $entity)
    {
        $entity->save();
        return $entity;
    }

    /**
     * Saves a Entity to the database.
     *
     * @param Entity $entity
     * @return Entity
     */
    public function save(Entity $entity)
    {
        $entity->save();
        return $entity;
    }
}
