<?php

namespace Telegram\Bot\Exceptions;

use Exception;

/**
 * Class TelegramSDKException.
 */
class TelegramSDKException extends Exception
{
    /**
     * Thrown when token is not provided.
     */
    public static function tokenNotProvided(string $tokenEnvName): self
    {
        return new static('Required "token" not supplied in config and could not find fallback environment variable '.$tokenEnvName.'');
    }

    /**
     * Thrown when file download fails.
     *
     * @return static
     */
    public static function fileDownloadFailed(string $reason, ?string $url = null): self
    {
        return new static($reason.': Failed to Download File '.$url);
    }
}
