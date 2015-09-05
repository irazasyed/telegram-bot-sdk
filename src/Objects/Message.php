<?php

namespace Telegram\Bot\Objects;

/**
 * Class Message
 *
 * @package Telegram\Bot\Objects
 *
 * @method int              getMessageId()              Unique message identifier.
 * @method User             getFrom()                   Sender.
 * @method int              getDate()                   Date the message was sent in Unix time.
 * @method User|GroupChat   getChat()                   Conversation the message belongs to, private or group.
 * @method User             getForwardFrom()            (Optional). For forwarded messages, sender of the original message.
 * @method int              getForwardDate()            (Optional). For forwarded messages, date the original message was sent in Unix time.
 * @method Message          getReplyToMessage()         (Optional). For replies, the original message. Note that the Message object in this field will not contain further reply_to_message fields even if it itself is a reply.
 * @method string           getText()                   (Optional). For text messages, the actual UTF-8 text of the message.
 * @method Audio            getAudio()                  (Optional). Message is an audio file, information about the file.
 * @method Document         getDocument()               (Optional). Message is a general file, information about the file.
 * @method PhotoSize[]      getPhoto()                  (Optional). Message is a photo, available sizes of the photo.
 * @method Sticker          getSticker()                (Optional). Message is a sticker, information about the sticker.
 * @method Video            getVideo()                  (Optional). Message is a video, information about the video.
 * @method Voice            getVoice()                  (Optional). Message is a voice message, information about the file.
 * @method string           getCaption()                (Optional). Caption for the photo or video contact
 * @method Contact          getContact()                (Optional). Message is a shared contact, information about the contact.
 * @method Location         getLocation()               (Optional). Message is a shared location, information about the location.
 * @method User             getNewChatParticipant()     (Optional). A new member was added to the group, information about them (this member may be bot itself).
 * @method User             getLeftChatParticipant()    (Optional). A member was removed from the group, information about them (this member may be bot itself).
 * @method string           getNewChatTitle()           (Optional). A group title was changed to this value.
 * @method PhotoSize[]      getNewChatPhoto()           (Optional). A group photo was change to this value.
 * @method bool             getDeleteChatPhoto()        (Optional). Informs that the group photo was deleted.
 * @method bool             getGroupChatCreated()       (Optional). Informs that the group has been created.
 */
class Message extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'chat' => $this->mapChatRelative(),
            'from' => User::class,
            'forward_from' => User::class,
            'reply_to_message' => Message::class,
            'audio' => Audio::class,
            'document' => Document::class,
            'photo' => PhotoSize::class,
            'sticker' => Sticker::class,
            'video' => Video::class,
            'voice' => Voice::class,
            'contact' => Contact::class,
            'location' => Location::class,
            'new_chat_participant' => User::class,
            'left_chat_participant' => User::class,
            'new_chat_photo' => PhotoSize::class,
        ];
    }

    /**
     * Find chat type and return appropriate class.
     *
     * @return mixed
     */
    protected function mapChatRelative()
    {
        return $this->get('chat.title', false) ? GroupChat::class : User::class;
    }
}
