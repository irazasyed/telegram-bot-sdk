<?php

namespace Telegram\Bot\Laravel\Facades;

use Illuminate\Support\Facades\Facade;
use Telegram\Bot\Api;
use Telegram\Bot\BotsManager;

/**
 * Class Telegram.
 *
 * @method static list<Api> getBots(string $name)
 * @method static Api bot((string | null) $name = null)
 * @method static Api reconnect((string | null) $name = null)
 * @method static BotsManager disconnect((string | null) $name = null)
 *
 * @mixin BotsManager
 */
final class Telegram extends Facade
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
