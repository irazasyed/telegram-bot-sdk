<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string  $fileHash     Checksum of encrypted file
 * @property string  $secret       Secret of encrypted file
 *
 * @link https://core.telegram.org/bots/api#filecredentials
 */
class FileCredentials extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
        ];
    }
}
