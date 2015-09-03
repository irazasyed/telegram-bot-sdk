<?php

namespace Irazasyed\Telegram\Objects;

/**
 * Class Message
 *
 * @package Irazasyed\Telegram\Objects
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
