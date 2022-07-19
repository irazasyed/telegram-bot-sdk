<?php

namespace Telegram\Bot\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Telegram\Bot\BotsManager;

/**
 * Class Telegram.
 *
 * @method static list<\Telegram\Bot\Api> getBots(string $name)
 * @method static \Telegram\Bot\Api bot(string|null $name)
 * @method static \Telegram\Bot\Api reconnect(string|null $name)
 * @method static \Telegram\Bot\BotsManager disconnect(string|null $name)
 *
 * @mixin \Telegram\Bot\BotsManager
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
