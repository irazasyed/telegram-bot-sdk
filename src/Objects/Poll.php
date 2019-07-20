<?php

namespace Telegram\Bot\Objects;

/**
 * Class Poll.
 *
 *
 * @property string       $id           Unique poll identifier
 * @property string       $question     Poll question, 1-255 characters.
 * @property PollOption[] $options      List of poll options
 * @property bool         $isClosed     True, if the poll is closed.
 */
class Poll extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'options' => PollOption::class,
        ];
    }
}
