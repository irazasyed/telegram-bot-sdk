<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\TelegramService;

/**
 * Class Telegram.
 */
trait Telegram
{
    /** @var TelegramService Holds the Super Class Instance. */
    protected $telegram = null;

    /**
     * Returns Super Class Instance.
     *
     * @return TelegramService
     */
    public function getTelegram(): TelegramService
    {
        return $this->telegram;
    }

    /**
     * Set Telegram TelegramService Instance.
     *
     * @param TelegramService $telegram
     *
     * @return $this
     */
    public function setTelegram(TelegramService $telegram)
    {
        $this->telegram = $telegram;

        return $this;
    }
}
