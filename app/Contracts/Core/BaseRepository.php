<?php

namespace App\Contracts\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
     * Creates and saves an model to the database.
     *
     * @param Model $model
     * @return Model
     */
    public function create(Model $model);

    /**
     * Soft-deletes/removes an model.
     *
     * @param Model $model The BaseModel to delete.
     * @return bool|null
     */
    public function delete(Model $model);

    /**
     * Soft-deletes/removes an model.
     *
     * @param Model $model The BaseModel to delete.
     * @return bool|null
     */
    public function remove(Model $model);

    /**
     * Stores the model in the cache.
     *
     * @param Model|null $model
     * @return mixed
     */
    public function storeModelInCache($model);

    /**
     * Stores the collection of entities in the cache.
     *
     * @param Collection $collection
     * @param null $keyOverride
     * @return Collection
     */
    public function storeCollectionInCache(Collection $collection, $keyOverride = null);

    /**
     * Invalidates the cache for the model, essentially forcing a new fetch.
     *
     * @param Model $model
     * @return bool
     */
    public function invalidateCacheFor(Model $model);

    /**
     * Restores the soft-deleted model.
     *
     * @param Model $model
     * @return bool|null Success restoring the model.
     */
    public function restore(Model $model);
}
