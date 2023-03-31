<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatJoinRequest.
 *
 * @link https://core.telegram.org/bots/api#chatjoinrequest
 *
 * @property Chat                   $chat           Chat to which the request was sent.
 * @property User                   $from           User that sent the join request.
 * @property int                    $date           Date the request was sent in Unix time.
 * @property string|null            $bio            Optional. Bio of the user.
 * @property ChatInviteLink|null    $invite_link    Optional. Chat invite link that was used by the user to send the join request.
 */
class ChatJoinRequest extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{chat: string, from: string, invite_link: string}
     */
    public function relations(): array
    {
        return [
            'chat' => Chat::class,
            'from' => User::class,
            'invite_link' => ChatInviteLink::class,
        ];
    }
}
