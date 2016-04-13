<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChosenInlineResult.
 *
 *
 * @method string       getResultId()           The unique identifier for the result that was chosen.
 * @method User         getFrom()               The user that chose the result.
 * @method Location     getLocation()           (Optional). Sender location, only for bots that require user location.
 * @method string       getInlineMessageId()    Optional. Identifier of the sent inline message. Available only if there is an inline keyboard attached to the message. Will be also received in callback queries and can be used to edit the message.
 * @method string       getQuery()              The query that was used to obtain the result.
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
            'from'     => User::class,
            'location' => Location::class,
        ];
    }
}
