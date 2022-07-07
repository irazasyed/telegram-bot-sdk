<?php

namespace Telegram\Bot\Objects;

/**
 * Class PollAnswer.
 *
 * @link https://core.telegram.org/bots/api#pollanswer
 *
 * @property string       $pollId       Unique poll identifier.
 * @property User         $user         The user, who changed the answer to the poll.
 * @property array        $optionIds    Array of Integer. 0-based identifiers of answer options, chosen by the user. May be empty if the user retracted their vote.
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
