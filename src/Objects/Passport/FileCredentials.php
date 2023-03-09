<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#filecredentials
 *
 * @property string  $fileHash     Checksum of encrypted file
 * @property string  $secret       Secret of encrypted file
 */
class FileCredentials extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [
        ];
    }
}
