<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Class UpdateWasReceived.
 */
final class UpdateWasReceived extends AbstractEvent
{
    /**
     * UpdateWasReceived constructor.
     */
    public function __construct(public Api $telegram, public Update $update) {}

    public function eventName(): string
    {
        return self::class;
    }

    /**
     * Backwards compatibility method
     *
     * @deprecated use eventName instead
     */
    public function getName(): string
    {
        return self::class;
    }
}
