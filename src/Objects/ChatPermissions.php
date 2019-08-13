<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatPermissions.
 *
 * @property bool $canSendMessages                        (Optional). True, if the user is allowed to send text messages, contacts, locations and venues
 * @property bool $canSendMediaMessages                   (Optional). True, if the user is allowed to send audios, documents, photos, videos, video notes and voice notes, implies can_send_messages
 * @property bool $canSendPolls                           (Optional). True, if the user is allowed to send polls, implies can_send_messages
 * @property bool $canSendOtherMessages                   (Optional). True, if the user is allowed to send animations, games, stickers and use inline bots, implies can_send_media_messages
 * @property bool $canAddWebPagePreviews                  (Optional). True, if the user is allowed to add web page previews to their messages, implies can_send_media_messages
 * @property bool $canChangeInfo                          (Optional). True, if the user is allowed to change the chat title, photo and other settings. Ignored in public supergroups
 * @property bool $canInviteUsers                         (Optional). True, if the user is allowed to invite new users to the chat
 * @property bool $canPinMessages                         (Optional). True, if the user is allowed to pin messages. Ignored in public supergroups
 */
class ChatPermissions extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'user' => User::class,
        ];
    }
}
