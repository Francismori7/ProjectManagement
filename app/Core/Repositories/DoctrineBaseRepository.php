<?php

namespace App\Core\Repositories;

use App\Contracts\Core\BaseRepository;
use App\Core\Models\BaseEntity;
use Doctrine\ORM\EntityRepository;

class DoctrineBaseRepository extends EntityRepository implements BaseRepository
{
    /**
     * Saves a Entity to the database.
     *
     * @param BaseEntity $entity
     */
    public function save(BaseEntity $entity)
    {
        $this->persist($entity);
    }

    /**
     * Sets the Entity entity to be persisted to the database on the next database transaction commit.
     *
     * @param BaseEntity $entity The Entity to save to the database.
     */
    public function persist(BaseEntity $entity)
    {
        $this->_em->persist($entity);
    }

    /**
     * Commits a database transaction.
     * @param BaseEntity $entity
     */
    public function flush(BaseEntity $entity = null)
    {
        $this->_em->flush($entity);
    }

    /**
     * Soft-deletes/removes a User.
     * @param BaseEntity $entity The BaseEntity to delete.
     */
    public function delete(BaseEntity $entity)
    {
        $this->_em->remove($entity);
    }
}