<?php

namespace Telegram\Bot\Objects;

/**
 * Class Update.
 *
 *
 * @method int      getUpdateId()   The update's unique identifier. Update identifiers start from a certain positive number and increase sequentially.
 * @method Message  getMessage()    (Optional). New incoming message of any kind - text, photo, sticker, etc.
 */
class Update extends BaseObject
{
    /**
     * {@inheritdoc}
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
