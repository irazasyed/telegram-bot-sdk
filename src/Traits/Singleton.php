<?php
namespace Telegram\Bot\Traits;

/**
 * Singleton
 */
trait Singleton
{
    /** @var null The reference to singleton instance of this class. */
    private static $instance = null;

    /**
     * Returns the singleton instance of this class.
     *
     * @return static The Singleton instance.
     */
    public static function Instance()
    {
        if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    /**
     * Protected constructor to prevent creating a new instance of the
     * Singleton via the `new` operator from outside of this class.
     */
    protected function __construct()
    {
    }

    /**
     * Private clone method to prevent cloning of the instance of the
     * Singleton instance.
     *
     * @return void
     */
    private function __clone()
    {
    }

    /**
     * Private unserialize method to prevent unserializing of the Singleton
     * instance.
     *
     * @return void
     */
    private function __wakeup()
    {
    }
}