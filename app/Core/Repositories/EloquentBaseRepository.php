<?php

namespace App\Core\Repositories;

use App\Contracts\Core\BaseRepository;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EloquentBaseRepository implements BaseRepository
{
    /**
     * Default caching time in minutes.
     */
    const DEFAULT_CACHING_TIME = 10;

    /**
     * The base model name used for caching.
     *
     * @var string
     */
    protected $modelName = 'base';

    /**
     * Enables or disables the caching of the entities in this repository.
     *
     * @var bool
     */
    protected $caching = true;

    /**
     * @var CacheRepository
     */
    protected $cache;

    /**
     * Soft-deletes/removes an model.
     *
     * @param Model $model The Model to delete.
     * @return bool|null
     */
    public function remove(Model $model)
    {
        return $this->delete($model);
    }

    /**
     * Soft-deletes/removes an model.
     *
     * @param Model $model The Model to delete.
     * @return bool|null
     */
    public function delete(Model $model)
    {
        $this->invalidateCacheFor($model);

        return $model->delete();
    }

    /**
     * Invalidates the cache for the model, essentially forcing a new fetch.
     *
     * @param Model $model
     * @return bool
     */
    public function invalidateCacheFor(Model $model)
    {
        if (! $this->caching) {
            return false;
        }

        // An model is now potentially invalid in the collection cache as well.
        $this->cache->forget($this->getCollectionCacheKey());

        return $this->cache->forget($this->getCacheKey($model));
    }

    /**
     * Returns the key name for the caching of collections (all)
     *
     * @return string
     * @throws \Exception
     */
    protected function getCollectionCacheKey()
    {
        if($this->modelName === "base") {
            throw new \Exception("Please rename the \$modelName property in " . __CLASS__);
        }

        return str_plural($this->modelName);
    }

    /**
     * Returns the key name for the cache.
     *
     * @param Model $model
     * @return string
     * @throws \Exception
     */
    protected function getCacheKey(Model $model)
    {
        if($this->modelName === "base") {
            throw new \Exception("Please rename the \$modelName property in " . __CLASS__);
        }

        return "{$this->modelName}:{$model->getKey()}";
    }

    /**
     * Creates and saves an model to the database.
     *
     * @param Model $model
     * @return Model
     */
    public function create(Model $model)
    {
        return $this->save($model);
    }

    /**
     * Saves a model to the database.
     *
     * @param Model $model
     * @return Model
     */
    public function save(Model $model)
    {
        $model->save();

        $this->invalidateCacheFor($model);

        return $this->storeModelInCache($model);
    }

    /**
     * Stores the model in the cache.
     *
     * @param Model|null $model
     * @return mixed
     */
    public function storeModelInCache($model)
    {
        if ($model === null) {
            return $model;
        }

        if (! $this->caching) {
            return $model;
        }

        return $this->cache->remember(
            $this->getCacheKey($model), self::DEFAULT_CACHING_TIME,
            function () use ($model) {
                return $model;
            }
        );
    }

    /**
     * Stores the collection of entities in the cache.
     *
     * @param Collection $collection
     * @return Collection
     */
    public function storeCollectionInCache(Collection $collection)
    {
        if (! $this->caching) {
            return $collection;
        }

        return $this->cache->remember(
            $this->getCollectionCacheKey(), self::DEFAULT_CACHING_TIME,
            function () use ($collection) {
                return $collection;
            }
        );
    }

    /**
     * EloquentBaseRepository constructor.
     *
     * @param CacheRepository $cache
     */
    public function __construct(CacheRepository $cache)
    {
        $this->cache = $cache;
    }
}
