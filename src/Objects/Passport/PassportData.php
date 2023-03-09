<?php

namespace Telegram\Bot\Objects\Passport;

use Telegram\Bot\Objects\BaseObject;

/**
 * @property array $data           Array with information about documents and other Telegram Passport elements that was shared with the bot
 * @property int $credentials      Encrypted credentials required to decrypt the data
 *
 * @link https://core.telegram.org/bots/api#passportdata
 */
class PassportData extends BaseObject
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
