<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\Api;
use Telegram\Bot\Bots\Bot;
use Telegram\Bot\Objects\Update;

class UpdateWasReceived extends AbstractEvent
{
    /**
     * @var Update
     */
    private $update;

    /**
     * @var Bot
     */
    private $bot;

    /**
     * UpdateWasReceived constructor.
     *
     * @param Update $update
     * @param Api    $telegram
     */
    public function __construct(Update $update, Bot $bot)
    {
        $this->update = $update;
        $this->bot = $bot;
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
        return $this->bot->getApi();
    }
    
    /**
     * @return Bot
     */
    public function getBot()
    {
        return $this->bot;
    }
}
