<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatMember.
 *
 * @method User            getUser()             Information about the user.
 * @method string          getStatus()           (Optional). The member's status in the chat. Can be “creator”, “administrator”, “member”, “left” or “kicked”
 */
class ChatMember extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'user'    => User::class,
        ];
    }
}
