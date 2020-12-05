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
     * Throw an exception when the user tries to clone the *Singleton*
     * instance.
     *
     * @throws \LogicException always
     */
    public function __clone()
    {
        throw new \LogicException('This Singleton cannot be cloned');
    }

    /**
     * Throw an exception when the user tries to unserialize the *Singleton*
     * instance.
     *
     * @throws \LogicException always
     */
    public function __wakeup()
    {
        throw new \LogicException('This Singleton cannot be serialised');
    }

    public static function destroy()
    {
        self::$instance = null;
    }
}
