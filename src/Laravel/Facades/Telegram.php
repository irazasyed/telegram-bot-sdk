<?php

namespace Irazasyed\Telegram\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Telegram
 *
 * @package Irazasyed\Telegram\Laravel\Facades
 */
class Telegram extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'telegram';
    }
}
