<?php

namespace Telegram\Bot\Traits;

use Telegram\Bot\Api;

/**
 * Class Telegram.
 */
trait Telegram
{
    /** @var Api Holds the Super Class Instance. */
    protected $telegram = null;

    /**
     * Returns Super Class Instance.
     */
    public function getTelegram(): Api
    {
        return $this->telegram;
    }

    /**
     * Set Telegram Api Instance.
     *
     * @return $this
     */
    public function setTelegram(Api $telegram)
    {
        $this->telegram = $telegram;

        return $this;
    }
}
