<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatLocation.
 *
 * @link https://core.telegram.org/bots/api#chatlocation
 *
 * @property Location $location          The location to which the supergroup is connected. Can't be a live location.
 * @property string   $address           Location address; 1-64 characters, as defined by the chat owner
 */
class ChatLocation extends BaseObject
{
    public function relations()
    {
        return [
            'location' => Location::class,
        ];
    }
}
