<?php

namespace Telegram\Bot\Objects;

/**
 * Class Message.
 *
 * @property int              $messageId              Unique message identifier.
 * @property User             $from                   (Optional). Sender, can be empty for messages sent to channels.
 * @property int              $date                   Date the message was sent in Unix time.
 * @property Chat             $chat                   Conversation the message belongs to.
 * @property User             $forwardFrom            (Optional). For forwarded messages, sender of the original message.
 * @property int              $forwardDate            (Optional). For forwarded messages, date the original message was sent in Unix time.
 * @property Message          $replyToMessage         (Optional). For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
 * @property int              $editDate               (Optional). Date the message was last edited in Unix time.
 * @property string           $text                   (Optional). For text messages, the actual UTF-8 text of the message, 0-4096 characters.
 * @property MessageEntity[]  $entities               (Optional). For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text.
 * @property Audio            $audio                  (Optional). Message is an audio file, information about the file.
 * @property Document         $document               (Optional). Message is a general file, information about the file.
 * @property Game             $game                   (Optional). Message is a game, information about the game.
 * @property PhotoSize[]      $photo                  (Optional). Message is a photo, available sizes of the photo.
 * @property Sticker          $sticker                (Optional). Message is a sticker, information about the sticker.
 * @property Video            $video                  (Optional). Message is a video, information about the video.
 * @property Voice            $voice                  (Optional). Message is a voice message, information about the file.
 * @property Contact          $contact                (Optional). Message is a shared contact, information about the contact.
 * @property Location         $location               (Optional). Message is a shared location, information about the location.
 * @property Venue            $venue                  (Optional). Message is a venue, information about the venue.
 * @property User             $newChatMember          (Optional). A new member was added to the group, information about them (this member may be the bot itself).
 * @property User             $leftChatMember         (Optional). A member was removed from the group, information about them (this member may be the bot itself).
 * @property string           $newChatTitle           (Optional). A chat title was changed to this value.
 * @property PhotoSize[]      $newChatPhoto           (Optional). A chat photo was change to this value.
 * @property bool             $deleteChatPhoto        (Optional). Service message: the chat photo was deleted.
 * @property bool             $groupChatCreated       (Optional). Service message: the group has been created.
 * @property bool             $supergroupChatCreated  (Optional). Service message: the super group has been created.
 * @property bool             $channelChatCreated     (Optional). Service message: the channel has been created.
 * @property int              $migrateToChatId        (Optional). The group has been migrated to a supergroup with the specified identifier, not exceeding 1e13 by absolute value.
 * @property int              $migrateFromChatId      (Optional). The supergroup has been migrated from a group with the specified identifier, not exceeding 1e13 by absolute value.
 * @property Message          $pinnedMessage          (Optional). Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
 */
class Message extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'from'             => User::class,
            'chat'             => Chat::class,
            'forward_from'     => User::class,
            'forward_from_chat'=> User::class,
            'reply_to_message' => self::class,
            'entities'         => MessageEntity::class,
            'audio'            => Audio::class,
            'document'         => Document::class,
            'game'             => Game::class,
            'photo'            => PhotoSize::class,
            'sticker'          => Sticker::class,
            'video'            => Video::class,
            'voice'            => Voice::class,
            'contact'          => Contact::class,
            'location'         => Location::class,
            'venue'            => Venue::class,
            'new_chat_member'  => User::class,
            'left_chat_member' => User::class,
            'new_chat_photo'   => PhotoSize::class,
            'pinned_message'   => self::class,
        ];
    }

    /**
     * Determine if the message is of given type
     *
     * @param string         $type
     *
     * @return bool
     */
    public function isType($type)
    {
        if ($this->has(strtolower($type))) {
            return true;
        }

        return $this->detectType() === $type;
    }
    
    
    /**
     * Detect type based on properties.
     *
     * @return string|null
     */
    public function detectType()
    {
        $types = [
            'text',
            'audio',
            'document',
            'game',
            'photo',
            'sticker',
            'video',
            'voice',
            'contact',
            'location',
            'venue',
            'new_chat_member',
            'left_chat_member',
            'new_chat_title',
            'new_chat_photo',
            'delete_chat_photo',
            'group_chat_created',
            'supergroup_chat_created',
            'channel_chat_created',
            'migrate_to_chat_id',
            'migrate_from_chat_id',
            'pinned_message',
        ];

        return $this->keys()
            ->intersect($types)
            ->pop();
    }
}
