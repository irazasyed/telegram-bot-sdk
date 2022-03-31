<?php

namespace Telegram\Bot\Exceptions;

use Throwable;

class TelegramRateLimitedException extends TelegramSDKException
{
    /**
     * Throttled time value
     *
     * @var int
     */
    private $value;

    public function __construct($message, int $value, $code = 429, Throwable $previous = null)
    {
        $this->setValue($value);

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }
}
