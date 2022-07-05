<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatMemberUpdated.
 *
 *
 * @property Chat                   $chat               Chat the user belongs to.
 * @property User                   $from               Performer of the action, which resulted in the change.
 * @property int                    $date               Date the change was done in Unix time.
 * @property ChatMember             $old_chat_member    Previous information about the chat member.
 * @property ChatMember             $new_chat_member    Previous information about the chat member.
 * @property ChatInviteLink|null    $invite_link        Optional. Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
 */
class ChatMemberUpdated extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'chat' => Chat::class,
            'from' => User::class,
            'old_chat_member' => ChatMember::class,
            'new_chat_member' => ChatMember::class,
            'invite_link' => ChatInviteLink::class,
        ];
    }
}
