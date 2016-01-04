<?php

namespace Telegram\Bot\Objects;

/**
 * Class InlineQuery.
 *
 *
 * @method int              getMessageId()              Unique message identifier.
 * @method User             getFrom()                   (Optional). Sender, can be empty for messages sent to channels.
 */
class InlineQuery extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'from' => User::class,
        ];
    }
}
