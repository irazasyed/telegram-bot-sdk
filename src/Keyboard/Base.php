<?php

namespace Telegram\Bot\Keyboard;

use Illuminate\Support\Collection;

/**
 * Class Base.
 */
class Base extends Collection
{
    /**
     * Dynamically build params.
     *
     * @param string $method
     * @param array  $args
     *
     * @return $this
     */
    public function __call($method, $args)
    {
        if (! starts_with($method, 'set')) {
            return parent::__call($method, $args);
        }
        $property = snake_case(substr($method, 3));
        $this->items[$property] = $args[0];

        return $this;
    }
}
