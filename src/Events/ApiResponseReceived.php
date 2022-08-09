<?php declare(strict_types=1);

namespace Telegram\Bot\Events;

use League\Event\AbstractEvent;
use Telegram\Bot\TelegramResponse;

final class ApiResponseReceived extends AbstractEvent
{
    /** @var \Telegram\Bot\TelegramResponse */
    private $response;

    public function __construct(TelegramResponse $response)
    {
        $this->response = $response;
    }

    public function getResponse(): TelegramResponse
    {
        return $this->response;
    }
}
