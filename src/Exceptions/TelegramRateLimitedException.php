<?php

namespace Telegram\Bot\Exceptions;

use Throwable;

class TelegramRateLimitedException extends TelegramSDKException
{
    /**
     * Threshold time value
     *
     * @var int
     */
    private $value;

    public function __construct($message, int $value, $code = 429, Throwable $previous = null)
    {
        $this->setThresholdValue($value);

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getThresholdValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setThresholdValue(int $value): void
    {
        $this->value = $value;
    }
}
