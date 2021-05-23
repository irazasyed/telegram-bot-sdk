<?php

namespace Telegram\Bot\Exceptions;

use Exception;

/**
 * Class TelegramException.
 */
class TelegramException extends Exception
{
    /**
     * Thrown when token is not provided.
     *
     * @param $tokenEnvName
     *
     * @return TelegramException
     */
    public static function tokenNotProvided($tokenEnvName): self
    {
        return new self('Required "token" not supplied in config and could not find fallback environment variable ' . $tokenEnvName . '');
    }
}
