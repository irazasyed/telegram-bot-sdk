<?php

namespace Telegram\Bot\Keyboard;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

/**
 * Class Base.
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends Collection<TKey, TValue>
 */
class Base extends Collection
{
    /**
     * Dynamically build params.
     *
     * @param  string  $method
     * @return $this
     */
    public function __call($method, $parameters)
    {
        if (! Str::startsWith($method, 'set')) {
            return parent::__call($method, $parameters);
        }

        $property = Str::snake(substr($method, 3));
        $this->items[$property] = $parameters[0];

        return $this;
    }
}
