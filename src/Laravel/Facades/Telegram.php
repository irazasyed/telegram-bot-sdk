<?php

namespace Telegram\Bot\Laravel\Facades;

use Telegram\Bot\BotsManager;
use Illuminate\Support\Facades\Facade;

/**
 * Class Telegram.
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
        return BotsManager::class;
    }
}
