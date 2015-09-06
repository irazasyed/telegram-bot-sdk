<?php

namespace Telegram\Bot\Objects;

/**
 * Class GroupChat
 *
 * @package Telegram\Bot\Objects
 *
 * @method int      getId()     Unique identifier for this group chat.
 * @method string   getTitle()  Group name.
 */
class GroupChat extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [];
    }
}
