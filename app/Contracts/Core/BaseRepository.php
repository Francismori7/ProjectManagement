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
     * @return $this
     */
    public function save(BaseEntity $entity);

    /**
     * Creates and saves an Entity to the database.
     *
     * @param BaseEntity $entity
     * @return $this
     */
    public function create(BaseEntity $entity);

    /**
     * Sets the Entity entity to be persisted to the database on the next database transaction commit.
     *
     * @param BaseEntity $entity The Entity to save to the database.
     * @return $this
     */
    public function persist(BaseEntity $entity);

    /**
     * Commits a database transaction.
     *
     * @param BaseEntity $entity
     * @return $this
     */
    public function flush(BaseEntity $entity = null);

    /**
     * Soft-deletes/removes a User.
     *
     * @param BaseEntity $entity The BaseEntity to delete.
     * @return $this
     */
    public function delete(BaseEntity $entity);

    /**
     * Soft-deletes/removes a User.
     *
     * @param BaseEntity $entity The BaseEntity to delete.
     * @return $this
     */
    public function remove(BaseEntity $entity);
}