<?php

namespace Telegram\Bot\Traits;

use Illuminate\Contracts\Container\Container;

/**
 * HasContainer.
 */
trait HasContainer
{
    /**
     * @var Container IoC Container
     */
    protected static $container = null;

    /**
     * Set the IoC Container.
     *
     * @param $container Container instance
     */
    public static function setContainer(Container $container)
    {
        self::$container = $container;
    }

    /**
     * Get the IoC Container.
     */
    public function getContainer(): Container
    {
        return self::$container;
    }

    /**
     * Check if IoC Container has been set.
     */
    public function hasContainer(): bool
    {
        return self::$container !== null;
    }
}
