<?php

namespace App\Core\Repositories;

use App\Contracts\Core\BaseRepository;
use App\Core\Models\BaseEntity;
use Doctrine\Common\Persistence\ObjectRepository;
use Doctrine\ORM\EntityRepository;

class DoctrineBaseRepository extends EntityRepository implements BaseRepository
{
    /**
     * Commits a database transaction.
     *
     * @param BaseEntity $entity
     * @return $this
     */
    public function flush(BaseEntity $entity = null)
    {
        $this->_em->flush($entity);
        return $this;
    }

    /**
     * Soft-deletes/removes an entity.
     *
     * @param BaseEntity $entity The BaseEntity to delete.
     * @return $this
     */
    public function delete(BaseEntity $entity)
    {
        return $this->remove($entity);
    }

    /**
     * Soft-deletes/removes an entity.
     *
     * @param BaseEntity $entity The BaseEntity to delete.
     * @return $this
     */
    public function remove(BaseEntity $entity)
    {
        $this->_em->remove($entity);
        return $this;
    }

    /**
     * Creates and saves an Entity to the database.
     *
     * @param BaseEntity $entity
     * @return $this
     */
    public function create(BaseEntity $entity)
    {
        return $this->save($entity);
    }

    /**
     * Saves a Entity to the database.
     *
     * @param BaseEntity $entity
     * @return $this
     */
    public function save(BaseEntity $entity)
    {
        return $this->persist($entity);
    }

    /**
     * Sets the Entity entity to be persisted to the database on the next database transaction commit.
     *
     * @param BaseEntity $entity The Entity to save to the database.
     * @return $this
     */
    public function persist(BaseEntity $entity)
    {
        $this->_em->persist($entity);
        return $this;
    }
}
