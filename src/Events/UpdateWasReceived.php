<?php

namespace Telegram\Bot\Events;

use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Class UpdateWasReceived.
 */
class UpdateWasReceived extends AbstractEvent implements HasEventName
{
    /**
     * UpdateWasReceived constructor.
     */
    public function __construct(public Api $telegram, public Update $update)
    {
    }

    /**
     * Backwards compatibility method
     *
     * @deprecated use eventName instead
     */
    public function getName(): string
    {
        return static::class;
    }
}
