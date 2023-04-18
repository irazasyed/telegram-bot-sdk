<?php

namespace Telegram\Bot\Traits;

use Psr\Container\ContainerInterface;

/**
 * HasContainer.
 */
trait HasContainer
{
    /**
     * @var null|ContainerInterface IoC Container
     */
    protected static ?ContainerInterface $container = null;

    /**
     * Set the IoC Container.
     */
    public static function setContainer(ContainerInterface $container): void
    {
        self::$container = $container;
    }

    /**
     * Get the IoC Container.
     */
    public function getContainer(): ?ContainerInterface
    {
        return self::$container;
    }

    /**
     * Check if IoC Container has been set.
     */
    public function hasContainer(): bool
    {
        return self::$container instanceof ContainerInterface;
    }
}
