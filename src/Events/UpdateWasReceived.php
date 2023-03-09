<?php

namespace Telegram\Bot\Events;

use League\Event\HasEventName;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Class UpdateWasReceived.
 */
final class UpdateWasReceived implements HasEventName
{
    private const NAME = 'update.received';

    private Update $update;

    private Api $telegram;

    /**
     * UpdateWasReceived constructor.
     */
    public function __construct(Update $update, Api $telegram)
    {
        $this->update = $update;
        $this->telegram = $telegram;
    }

    public function update(): Update
    {
        return $this->update;
    }

    public function telegram(): Api
    {
        return $this->telegram;
    }

    public function eventName(): string
    {
        return self::NAME;
    }
}
