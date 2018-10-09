<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property string  $dataHash     Checksum of encrypted data
 * @property string  $secret       Secret of encrypted data
 *
 * @link https://core.telegram.org/bots/api#datacredentials
 */
class DataCredentials extends BaseObject
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
