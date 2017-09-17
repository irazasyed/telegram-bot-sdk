<?php
namespace Telegram\Bot\Keyboard;

use Illuminate\Support\Collection;

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
        $action = substr($method, 0, 3);

        if ($action !== 'set') {
            return parent::__call($method, $args);
        }

        $property = snake_case(substr($method, 3));
        $this->items[$property] = $args[0];

        return $this;

    }
}
