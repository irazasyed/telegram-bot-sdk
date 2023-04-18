<?php

namespace Telegram\Bot\Objects;

use Telegram\Bot\Objects\Passport\PassportData;
use Telegram\Bot\Objects\Payments\Invoice;
use Telegram\Bot\Objects\Payments\SuccessfulPayment;
use Telegram\Bot\Objects\WebApp\WebAppData;

/**
 * Class Message.
 *
 * @property int                    $messageId              Unique message identifier.
 * @property User|null              $from                   (Optional). Sender, can be empty for messages sent to channels.
 * @property int                    $date                   Date the message was sent in Unix time.
 * @property Chat                   $chat                   Conversation the message belongs to.
 * @property User|null              $forwardFrom            (Optional). For forwarded messages, sender of the original message.
 * @property Chat|null              $forwardFromChat        (Optional). For messages forwarded from a channel, information about the original channel.
 * @property int|null               $forwardFromMessageId   (Optional). For forwarded channel posts, identifier of the original message in the channel.
 * @property string|null            $forwardSignature       (Optional). For messages forwarded from channels, identifier of the original message in the channel
 * @property string|null            $forwardSenderName      (Optional). Sender's name for messages forwarded from users who disallow adding a link to their account in forwarded messages
 * @property int|null               $forwardDate            (Optional). For forwarded messages, date the original message was sent in Unix time.
 * @property Message|null           $replyToMessage         (Optional). For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
 * @property int|null               $editDate               (Optional). Date the message was last edited in Unix time.
 * @property string|null            $mediaGroupId           (Optional). The unique identifier of a media message group this message belongs to
 * @property string|null            $authorSignature        (Optional). Signature of the post author for messages in channels
 * @property string|null            $text                   (Optional). For text messages, the actual UTF-8 text of the message, 0-4096 characters.
 * @property MessageEntity[]|null   $entities               (Optional). For text messages, special entities like usernames, URLs, bot commands, etc. that appear in the text.
 * @property MessageEntity[]|null   $captionEntities        (Optional). For messages with a caption, special entities like usernames, URLs, bot commands, etc. that appear in the caption.
 * @property Audio|null             $audio                  (Optional). Message is an audio file, information about the file.
 * @property Document|null          $document               (Optional). Message is a general file, information about the file.
 * @property Animation|null         $animation              (Optional). Message is an animation, information about the animation. For backward compatibility, when this field is set, the document field will also be set
 * @property Game|null              $game                   (Optional). Message is a game, information about the game.
 * @property PhotoSize[]|null       $photo                  (Optional). Message is a photo, available sizes of the photo.
 * @property Sticker|null           $sticker                (Optional). Message is a sticker, information about the sticker.
 * @property Video|null             $video                  (Optional). Message is a video, information about the video.
 * @property Voice|null             $voice                  (Optional). Message is a voice message, information about the file.
 * @property VideoNote|null         $videoNote              (Optional). Message is a video note, information about the video message.
 * @property string|null            $caption                (Optional). Caption for the document, photo or video, 0-200 characters.
 * @property Contact|null           $contact                (Optional). Message is a shared contact, information about the contact.
 * @property Location|null          $location               (Optional). Message is a shared location, information about the location.
 * @property Venue|null             $venue                  (Optional). Message is a venue, information about the venue.
 * @property Poll|null              $poll                   (Optional). Message is a native poll, information about the poll
 * @property User[]|null            $newChatMembers         (Optional). New members that were added to the group or supergroup and information about them (the bot itself may be one of these members).
 * @property User|null              $leftChatMember         (Optional). A member was removed from the group, information about them (this member may be the bot itself).
 * @property string|null            $newChatTitle           (Optional). A chat title was changed to this value.
 * @property PhotoSize[]|null       $newChatPhoto           (Optional). A chat photo was change to this value.
 * @property bool|null              $deleteChatPhoto        (Optional). Service message: the chat photo was deleted.
 * @property bool|null              $groupChatCreated       (Optional). Service message: the group has been created.
 * @property bool|null              $supergroupChatCreated  (Optional). Service message: the super group has been created.
 * @property bool|null              $channelChatCreated     (Optional). Service message: the channel has been created.
 * @property int|null               $migrateToChatId        (Optional). The group has been migrated to a supergroup with the specified identifier, not exceeding 1e13 by absolute value.
 * @property int|null               $migrateFromChatId      (Optional). The supergroup has been migrated from a group with the specified identifier, not exceeding 1e13 by absolute value.
 * @property Message|null           $pinnedMessage          (Optional). Specified message was pinned. Note that the Message object in this field will not contain further reply_to_message fields even if it is itself a reply.
 * @property Invoice|null           $invoice                (Optional). Message is an invoice for a payment, information about the invoice.
 * @property SuccessfulPayment|null $successfulPayment      (Optional). Message is a service message about a successful payment, information about the payment.
 * @property string|null            $connectedWebsite       (Optional). The domain name of the website on which the user has logged in.
 * @property PassportData|null      $passportData           (Optional). Telegram Passport data
 * @property string|null            $replyMarkup            (Optional). Inline keyboard attached to the message. login_url buttons are represented as ordinary url buttons.
 * @property WebAppData|null        $webAppData             (Optional). Service message: data sent by a Web App.
 * @property Chat|null              $senderChat             (Optional). Sender of a message which is a chat (group or channel).
 */
class Message extends BaseObject
{
    /**
     * @var string[]
     */
    protected const TYPES = [
        'text',
        'audio',
        'animation',
        'dice',
        'document',
        'game',
        'photo',
        'sticker',
        'video',
        'video_note',
        'voice',
        'contact',
        'location',
        'venue',
        'poll',
        'new_chat_member',
        'new_chat_members',
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
        'invoice',
        'successful_payment',
        'passport_data',
        'proximity_alert_triggered',
        'voice_chat_started',
        'voice_chat_ended',
        'voice_chat_participants_invited',
        'web_app_data',
    ];

    /**
     * {@inheritdoc}
     *
     * @return array{from: string, chat: string, forward_from: string, forward_from_chat: string, reply_to_message: class-string<Message>, entities: string[], caption_entities: string[], audio: string, dice: string, animation: string, document: string, game: string, photo: string[], sticker: string, video: string, voice: string, video_note: string, contact: string, location: string, venue: string, poll: string, new_chat_member: string, new_chat_members: string[], left_chat_member: string, new_chat_photo: string[], delete_chat_photo: string, pinned_message: class-string<Message>, invoice: string, successful_payment: string, passport_data: string, sender_chat: string, proximity_alert_triggered: string, voice_chat_started: string, voice_chat_ended: string, voice_chat_participants_invited: string, web_app_data: string}
     */
    public function relations(): array
    {
        return [
            'from' => User::class,
            'chat' => Chat::class,
            'forward_from' => User::class,
            'forward_from_chat' => Chat::class,
            'reply_to_message' => self::class,
            'entities' => [MessageEntity::class],
            'caption_entities' => [MessageEntity::class],
            'audio' => Audio::class,
            'dice' => Dice::class,
            'animation' => Animation::class,
            'document' => Document::class,
            'game' => Game::class,
            'photo' => [PhotoSize::class],
            'sticker' => Sticker::class,
            'video' => Video::class,
            'voice' => Voice::class,
            'video_note' => VideoNote::class,
            'contact' => Contact::class,
            'location' => Location::class,
            'venue' => Venue::class,
            'poll' => Poll::class,
            'new_chat_member' => ChatMember::class,
            'new_chat_members' => [User::class],
            'left_chat_member' => User::class,
            'new_chat_photo' => [PhotoSize::class],
            'delete_chat_photo' => ChatPhoto::class,
            'pinned_message' => self::class,
            'invoice' => Invoice::class,
            'successful_payment' => SuccessfulPayment::class,
            'passport_data' => PassportData::class,
            'sender_chat' => Chat::class,
            'proximity_alert_triggered' => ProximityAlertTriggered::class,
            'voice_chat_started' => VoiceChatStarted::class,
            'voice_chat_ended' => VoiceChatEnded::class,
            'voice_chat_participants_invited' => VoiceChatParticipantsInvited::class,
            'web_app_data' => WebAppData::class,
        ];
    }

    /**
     * Determine if the message is of given type.
     */
    public function isType(string $type): bool
    {
        if ($this->has(strtolower($type))) {
            return true;
        }

        return $this->detectType() === $type;
    }

    /**
     * Detect type based on properties.
     */
    public function objectType(): ?string
    {
        return $this->detectType();
    }

    /**
     * Detect type based on properties.
     *
     * @deprecated Will be removed in v4.0, please use {@see Message::objectType} instead.
     */
    public function detectType(): ?string
    {
        return $this->findType(static::TYPES);
    }

    /**
     * Does this message contain a command entity.
     */
    public function hasCommand(): bool
    {
        return $this->get('entities', collect())->contains('type', 'bot_command');
    }
}
