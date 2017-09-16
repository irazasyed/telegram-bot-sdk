<?php

namespace Telegram\Bot\Objects;

/**
 * Class User.
 *
 *
 * @method int      getId()         Unique identifier for this user or bot.
 * @method bool     getIsBot()      True, if this user is a bot
 * @method string   getFirstName()  User's or bot's first name.
 * @method string   getLastName()   (Optional). User's or bot's last name.
 * @method string   getUsername()   (Optional). User's or bot's username.
 */
class User extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
