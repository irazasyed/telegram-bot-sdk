<?php

namespace Telegram\Bot\Exceptions;

/**
 * Class TelegramSDKException.
 */
class TelegramSDKException extends \Exception
{
    /**
     * Thrown when token is not provided.
     *
     * @param $tokenEnvName
     *
     * @return static
     */
    public static function tokenNotProvided($tokenEnvName)
    {
        return new static('Required "token" not supplied in config and could not find fallback environment variable '.$tokenEnvName.'');
    }
}
