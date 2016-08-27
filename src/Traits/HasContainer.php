<?php

namespace Telegram\Bot\Traits;

use Illuminate\Contracts\Container\Container;

/**
 * HasContainer
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
     *
     * @return void
     */
    public static function setContainer(Container $container)
    {
        self::$container = $container;
    }

    /**
     * Get the IoC Container.
     *
     * @return Container
     */
    public function getContainer()
    {
        return self::$container;
    }

    /**
     * Check if IoC Container has been set.
     *
     * @return boolean
     */
    public function hasContainer()
    {
        return self::$container !== null;
    }
}