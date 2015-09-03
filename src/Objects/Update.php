<?php

namespace Irazasyed\Telegram\Objects;

/**
 * Class Update
 *
 * @package Irazasyed\Telegram\Objects
 */
class Update extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'message' => Message::class,
        ];
    }

    /**
     * Get recent message.
     *
     * @return Update
     */
    public function recentMessage()
    {
        return new static($this->last());
    }
}
