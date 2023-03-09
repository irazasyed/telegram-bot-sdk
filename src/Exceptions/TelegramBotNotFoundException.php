<?php

namespace Telegram\Bot\Exceptions;

final class TelegramBotNotFoundException extends TelegramSDKException
{
    /**
     * @param string $name
     * @return TelegramBotNotFoundException
     */
    public static function create(string $name): self
    {
        return new TelegramBotNotFoundException(sprintf('Bot [%s] not configured.', $name));
    }
}