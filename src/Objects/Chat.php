<?php

namespace Telegram\Bot\Objects;

use Telegram\Bot\Objects\Inputmedia\InputMedia;

/**
 * Class Chat.
 *
 *
 * @property int             $id                           Unique identifier for this chat, not exceeding 1e13 by absolute value.
 * @property string          $type                         Type of chat, can be either 'private', 'group', 'supergroup' or 'channel'.
 * @property string          $title                        (Optional). Title, for channels and group chats.
 * @property string          $username                     (Optional). Username, for private chats and channels if available
 * @property string          $firstName                    (Optional). First name of the other party in a private chat
 * @property string          $lastName                     (Optional). Last name of the other party in a private chat
 * @property InputMedia      $photo                        (Optional). Chat photo. Returned only in getChat.
 * @property string          $description                  (Optional). Description, for groups, supergroups and channel chats. Returned only in getChat.
 * @property string          $inviteLink                   (Optional). Chat invite link, for groups, supergroups and channel chats. Each administrator in a chat generates their own invite links, so the bot must first generate the link using exportChatInviteLink. Returned only in getChat.
 * @property Message         $pinnedMessage                (Optional). Pinned message, for groups, supergroups and channels. Returned only in getChat.
 * @property ChatPermissions $permissions                  (Optional). Pinned message, for groups, supergroups and channels. Returned only in getChat.
 * @property int             $slowModeDelay                (Optional). For supergroups, the minimum allowed delay between consecutive messages sent by each unpriviledged user. Returned only in getChat.
 * @property string          $stickerSetName               (Optional). For supergroups, name of group sticker set. Returned only in getChat.
 * @property bool            $canSetStickerSet             (Optional). True, if the bot can change the group sticker set. Returned only in getChat.
 */
class Chat extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'photo'          => InputMedia::class,
            'pinned_message' => Message::class,
            'permissions'    => ChatPermissions::class,
        ];
    }
}
