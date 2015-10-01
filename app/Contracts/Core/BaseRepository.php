<?php

namespace App\Contracts\Core;

use App\Core\Models\BaseEntity;
use Doctrine\ORM\EntityRepository;

interface BaseRepository
{
    /**
     * Saves a Entity to the database.
     *
     * @param BaseEntity $entity
     */
    public function save(BaseEntity $entity);

    /**
     * Sets the Entity entity to be persisted to the database on the next database transaction commit.
     *
     * @param BaseEntity $entity The Entity to save to the database.
     */
    public function persist(BaseEntity $entity);

    /**
     * Commits a database transaction.
     * @param BaseEntity $entity
     */
    public function flush(BaseEntity $entity = null);

    /**
     * Soft-deletes/removes a User.
     * @param BaseEntity $entity The BaseEntity to delete.
     */
    public function delete(BaseEntity $entity);
}