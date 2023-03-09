<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @link https://core.telegram.org/bots/api#credentials
 *
 * @property SecureData $secureData   Credentials for encrypted data
 * @property string     $nonce        Bot-specified nonce
 */
class Credentials extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{secure_data: string}
     */
    public function relations(): array
    {
        return [
            'secure_data' => SecureData::class,
        ];
    }
}
