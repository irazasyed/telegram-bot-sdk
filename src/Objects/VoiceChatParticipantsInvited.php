<?php

namespace Telegram\Bot\Objects;

/**
 * Class VoiceChatParticipantsInvited.
 *
 * @link https://core.telegram.org/bots/api#voicechatended
 *
 * @property User[]|null $users (Optional). New members that were invited to the voice chat
 */
class VoiceChatParticipantsInvited extends BaseObject
{
    /** {@inheritDoc}
     * @return array{users: string[]} */
    public function relations(): array
    {
        return [
            'users' => [User::class],
        ];
    }
}
