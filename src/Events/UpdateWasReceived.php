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
    /**
     * @var string
     */
    private const NAME = 'update.received';

    /**
     * UpdateWasReceived constructor.
     */
    public function __construct(private Update $update, private Api $telegram)
    {
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
