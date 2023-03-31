<?php

namespace Telegram\Bot\Exceptions;

final class TelegramBotNotFoundException extends TelegramSDKException
{
    public static function create(string $name): self
    {
        return new TelegramBotNotFoundException(sprintf('Bot [%s] is not configured.', $name));
    }
}
