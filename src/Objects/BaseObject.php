<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class BaseObject.
 *
 * @mixin Collection
 */
abstract class BaseObject extends Collection
{
    /**
     * Builds collection entity.
     *
     * @param array|mixed $data
     */
    public function __construct($data)
    {
        parent::__construct($this->getRawResult($data));
    }

    /**
     * Property relations.
     *
     * @return array
     */
    abstract public function relations();

    /**
     * Magically access collection data.
     *
     * @param $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->getPropertyValue($property);
    }

    /**
     * Magically map to an object class (if exists) and return data.
     *
     * @param      $property
     * @param null $default
     *
     * @return mixed
     */
    protected function getPropertyValue($property, $default = null)
    {
        $property = Str::snake($property);
        if (! $this->offsetExists($property)) {
            return value($default);
        }

        $value = $this->items[$property];

        $relations = $this->relations();
        if (isset($relations[$property])) {
            return $this->getRelationValue($property, $value);
        }

        /** @var BaseObject $class */
        $class = 'Telegram\Bot\Objects\\'.Str::studly($property);

        if (class_exists($class)) {
            return $class::make($value);
        }

        if (is_array($value)) {
            return TelegramObject::make($value);
        }

        return $value;
    }

    /**
     * @param string $relationName
     * @param array  $relationRawData
     * @return array|\Illuminate\Support\Enumerable|\Illuminate\Support\Traits\EnumeratesValues|\Telegram\Bot\Objects\BaseObject
     */
    protected function getRelationValue(string $relationName, iterable $relationRawData)
    {
        /** @var class-string<\Telegram\Bot\Objects\BaseObject>|list<class-string<\Telegram\Bot\Objects\BaseObject>> $relation */
        $relation = $this->relations()[$relationName];

        if (is_string($relation) && class_exists($relation)) {
            return $relation::make($relationRawData);
        }

        $isOneToManyRelation = is_array($relation);
        if ($isOneToManyRelation) {
            /** @var class-string<\Telegram\Bot\Objects\BaseObject> $clasString */
            $clasString = $relation[0];
            $relatedObjects = Collection::make(); // @todo array type can be used in v4
            foreach ($relationRawData as $singleObjectRawData) {
                $relatedObjects[] = $clasString::make($singleObjectRawData);
            }
            return $relatedObjects;
        }

        throw new \InvalidArgumentException("Unknown type of the relationship data for the $relationName relation.");
    }

    /**
     * Get an item from the collection by key.
     *
     * @param mixed $key
     * @param mixed $default
     *
     * @return mixed|static
     */
    public function get($key, $default = null)
    {
        $value = parent::get($key, $default);

        if (null !== $value && is_array($value)) {
            return $this->getPropertyValue($key, $default);
        }

        return $value;
    }

    /**
     * Returns raw response.
     *
     * @return array|mixed
     */
    public function getRawResponse()
    {
        return $this->items;
    }

    /**
     * Returns raw result.
     *
     * @param $data
     *
     * @return mixed
     */
    public function getRawResult($data)
    {
        return data_get($data, 'result', $data);
    }

    /**
     * Get Status of request.
     *
     * @return mixed
     */
    public function getStatus()
    {
        return data_get($this->items, 'ok', false);
    }

    /**
     * Magic method to get properties dynamically.
     *
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if (! Str::startsWith($name, 'get')) {
            return false;
        }
        $property = substr($name, 3);

        return $this->getPropertyValue($property);
    }
}
