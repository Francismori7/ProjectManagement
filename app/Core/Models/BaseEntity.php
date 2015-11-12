<?php

namespace App\Core\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Arrayable as ArrayableContract;
use Illuminate\Contracts\Support\Jsonable as JsonableContract;
use LaravelDoctrine\ORM\Serializers\ArrayEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class BaseEntity
 * @package App\Core\Models
 */
abstract class BaseEntity implements JsonableContract, ArrayableContract
{
    /**
     * When serialized, these attributes will not be included.
     *
     * @var array
     */
    protected $ignoredAttributes = [];

    /**
     * Magic method that defers to the getters.
     *
     * @param $property
     * @return mixed
     */
    public function __get($property)
    {
        $methodName = 'get' . ucfirst($property);
        return call_user_func([$this, $methodName]);
    }

    /**
     * Magic method that defers to the setters.
     *
     * @param $property
     * @param $value
     * @return mixed
     */
    public function __set($property, $value)
    {
        $methodName = 'set' . ucfirst($property);
        return call_user_func([$this, $methodName], $value);
    }

    /**
     * Serializes the object into an array.
     *
     * @return string
     */
    public function toArray()
    {
        $serializer = new Serializer([$this->getNormalizer()], [
            'array' => new ArrayEncoder(),
        ]);

        return $serializer->serialize($this, 'array');
    }

    /**
     * @return GetSetMethodNormalizer
     */
    private function getNormalizer()
    {
        $dateTimeCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime ?
                Carbon::instance($dateTime)->toDateTimeString() :
                null;
        };

        $dateTimeProperties = ['createdAt', 'updatedAt', 'deletedAt'];
        $callbacks = [];

        foreach ($dateTimeProperties as $dateTimeProperty) {
            if (property_exists($this, $dateTimeProperty)) {
                $callbacks[$dateTimeProperty] = $dateTimeCallback;
            }
        }

        $normalizer = new GetSetMethodNormalizer;
        $normalizer->setIgnoredAttributes($this->ignoredAttributes);
        $normalizer->setCallbacks($callbacks);
        return $normalizer;
    }

    /**
     * Serializes the object into a Json object.
     *
     * @param int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        $serializer = new Serializer([$this->getNormalizer()], [
            'json' => new JsonEncoder(),
        ]);

        return $serializer->serialize($this, 'json', ['json_encode_options' => $options]);
    }
}
