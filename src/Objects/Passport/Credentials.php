<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property SecureData $secureData   Credentials for encrypted data
 * @property string     $nonce        Bot-specified nonce
 *
 * @link https://core.telegram.org/bots/api#credentials
 */
class Credentials extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'secure_data' => SecureData::class,
        ];
    }
}
