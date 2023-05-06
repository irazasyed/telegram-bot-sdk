<?php

namespace Telegram\Bot\Objects;

use Illuminate\Support\Collection;
use Illuminate\Support\Enumerable;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\EnumeratesValues;
use InvalidArgumentException;

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
     * @param  array|mixed  $data
     */
    public function __construct($data)
    {
        parent::__construct($this->getRawResult($data));
    }

    /**
     * Returns raw result.
     */
    public function getRawResult($data): mixed
    {
        return data_get($data, 'result', $data);
    }

    /**
     * Magically access collection data.
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->getPropertyValue($key);
    }

    public function __set(string $name, mixed $value): void
    {
        throw new InvalidArgumentException(sprintf('Cannot set property “%s” on “%s” immutable object.', $name, static::class));
    }

    /**
     * Magically map to an object class (if exists) and return data.
     *
     * @param  string  $property Name of the property or relation.
     * @param  mixed  $default Default value or \Closure that returns default value.
     */
    protected function getPropertyValue(string $property, mixed $default = null): mixed
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
     * Property relations.
     */
    abstract public function relations(): array;

    /**
     * @return array|Enumerable|EnumeratesValues|BaseObject
     */
    protected function getRelationValue(string $relativeName, iterable $relativeData): mixed
    {
        /** @var class-string<BaseObject>|list<class-string<BaseObject>> $relative */
        $relative = $this->relations()[$relativeName];

        if (is_string($relative)) {
            if (! class_exists($relative)) {
                throw new InvalidArgumentException(sprintf('Could not load “%s” relative: class “%s” not found.', $relativeName, $relative));
            }

            return $relative::make($relativeData);
        }

        /** @var class-string<BaseObject> $relativeClass */
        $relativeClass = $relative[0];
        $relatedObjects = Collection::make();
        // @todo array type can be used in v4
        foreach ($relativeData as $data) {
            $relatedObjects->add($relativeClass::make($data));
        }

        return $relatedObjects;
    }

    public function __isset(string $name): bool
    {
        return $this->getPropertyValue($name) !== null;
    }

    /**
     * Get an item from the collection by key.
     *
     * @param  mixed  $key
     * @param  mixed  $default
     */
    public function get($key, $default = null): mixed
    {
        $value = parent::get($key, $default);

        if (is_array($value)) {
            return $this->getPropertyValue($key, $default);
        }

        return $value;
    }

    /**
     * Returns raw response.
     *
     * @return array|mixed
     */
    public function getRawResponse(): mixed
    {
        return $this->items;
    }

    /**
     * Get Status of request.
     */
    public function getStatus(): mixed
    {
        return data_get($this->items, 'ok', false);
    }

    /**
     * Determine if the object is of given type.
     */
    public function isType(string $type): bool
    {
        if ($this->offsetExists($type)) {
            return true;
        }

        return $this->objectType() === $type;
    }

    /**
     * Detect type based on fields.
     */
    public function objectType(): ?string
    {
        return null;
    }

    /**
     * Magic method to get properties dynamically.
     *
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        if (! Str::startsWith($method, 'get')) {
            return false;
        }

        $property = substr($method, 3);

        return $this->getPropertyValue($property);
    }

    /**
     * Determine the type by given types.
     */
    protected function findType(array $types): ?string
    {
        return $this->keys()
            ->intersect($types)
            ->pop();
    }
}
