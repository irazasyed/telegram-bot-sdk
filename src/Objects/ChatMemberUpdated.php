<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatMemberUpdated.
 *
 * @link https://core.telegram.org/bots/api#chatmemberupdated
 *
 * @property Chat $chat Chat the user belongs to.
 * @property User $from Performer of the action, which resulted in the change.
 * @property int $date Date the change was done in Unix time.
 * @property ChatMember $oldChatMember Previous information about the chat member.
 * @property ChatMember $newChatMember New information about the chat member.
 * @property ChatInviteLink|null $inviteLink (Optional). Chat invite link, which was used by the user to join the chat; for joining by invite link events only.
 */
class ChatMemberUpdated extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{chat: string, from: string, old_chat_member: string, new_chat_member: string, invite_link: string}
     */
    public function relations(): array
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
