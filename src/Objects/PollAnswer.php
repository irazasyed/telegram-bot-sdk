<?php

namespace Telegram\Bot\Objects;

/**
 * Class PollAnswer.
 *
 *
 * @property string       $poll_id      Unique poll identifier.
 * @property User         $user         The user, who changed the answer to the poll.
 * @property array        $option_ids   0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
 */
class PollAnswer extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'user' => User::class,
        ];
    }
}
