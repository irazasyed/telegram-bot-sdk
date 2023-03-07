<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

/**
 * Class UpdateWasReceived.
 */
class UpdateWasReceived extends AbstractEvent
{
    /** @var Update */
    private $update;

    /** @var Api */
    private $telegram;

    /**
     * UpdateWasReceived constructor.
     */
    public function __construct(Update $update, Api $telegram)
    {
        $this->update = $update;
        $this->telegram = $telegram;
    }

    public function getUpdate(): Update
    {
        return $this->update;
    }

    public function getTelegram(): Api
    {
        return $this->telegram;
    }
}
