<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChosenInlineResult.
 *
 *
 * @method string       getResultId()       The unique identifier for the result that was chosen.
 * @method User         getFrom()           The user that chose the result.
 * @method string       getQuery()          The query that was used to obtain the result.
 * @link https://core.telegram.org/bots/api#choseninlineresult
 */
class ChosenInlineResult extends BaseObject
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
