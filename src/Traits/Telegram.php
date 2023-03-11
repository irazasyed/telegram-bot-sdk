<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Api;

/**
 * Class Telegram.
 */
trait Telegram
{
    /**
     * @var Api|null Telegram Api Instance.
     */
    protected ?Api $telegram = null;

    /**
     * Get Telegram Api Instance.
     */
    public function getTelegram(): Api
    {
        return $this->telegram;
    }

    /**
     * Set Telegram Api Instance.
     */
    public function setTelegram(Api $telegram): self
    {
        $this->telegram = $telegram;

        return $this;
    }
}
