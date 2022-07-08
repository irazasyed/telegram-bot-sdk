<?php

namespace Telegram\Bot\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Telegram\Bot\BotsManager;

/**
 * Class Telegram.
 *
 * @method static bool getBots(string $name):list<\Telegram\Bot\Api>
 * @method static bool bot(string|null $name):\Telegram\Bot\Api
 * @method static bool reconnect(string|null $name):\Telegram\Bot\Api
 * @method static bool disconnect(string|null $name):\Telegram\Bot\BotsManager
 *
 * @see \Telegram\Bot\BotsManager
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
