<?php

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\TelegramRequest;

final class ApiRequestSending extends AbstractEvent
{
    /** @var \Telegram\Bot\TelegramRequest */
    private $request;

    public function __construct(TelegramRequest $request)
    {
        $this->request = $request;
    }

    public function getRequest(): TelegramRequest
    {
        return $this->request;
    }
}
