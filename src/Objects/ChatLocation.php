<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatLocation.
 *
 * @link https://core.telegram.org/bots/api#chatlocation
 *
 * @property Location $location The location to which the supergroup is connected. Can't be a live location.
 * @property string $address Location address; 1-64 characters, as defined by the chat owner
 */
class ChatLocation extends BaseObject
{
    /**
     * @return array{location: string}
     */
    public function relations(): array
    {
        return [
            'location' => Location::class,
        ];
    }
}
