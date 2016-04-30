<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class UpdateWasReceived extends AbstractEvent
{
    /**
     * @var Update
     */
    private $update;

    /**
     * @var Api
     */
    private $telegram;

    /**
     * UpdateWasReceived constructor.
     *
     * @param Update $update
     * @param Api    $telegram
     */
    public function __construct(Update $update, Api $telegram)
    {
        $this->update = $update;
        $this->telegram = $telegram;
    }

    /**
     * @return Update
     */
    public function getUpdate()
    {
        return $this->update;
    }

    /**
     * @return Api
     */
    public function getTelegram()
    {
        return $this->telegram;
    }
}
