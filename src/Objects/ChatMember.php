<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatMember.
 *
 * @property User            $user             Information about the user.
 * @property string          $status           (Optional). The member's status in the chat. Can be “creator”, “administrator”, “member”, “left” or “kicked”
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
