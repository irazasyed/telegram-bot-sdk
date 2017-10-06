<?php

namespace Telegram\Bot\Traits;

/**
 * Singleton.
 */
trait Singleton
{
    public static $instance;

    /**
     * Returns the singleton instance of this class.
     *
     * @return static The Singleton instance.
     */
    public static function Instance()
    {
        if (null === self::$instance) {
            self::$instance = new static();
        }

        return self::$instance;
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

    public static function destroy()
    {
        self::$instance = null;
    }
}
