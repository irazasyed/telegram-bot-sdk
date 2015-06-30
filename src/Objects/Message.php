<?php

namespace Irazasyed\Telegram\Objects;

class Message extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'from' => User::class,
            'chat' => $this->mapChatRelative(),
            'audio' => Audio::class,
            'document' => Document::class,
            'photo' => PhotoSize::class,
            'sticker' => Sticker::class,
            'location' => Location::class,
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