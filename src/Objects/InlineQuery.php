<?php

namespace Telegram\Bot\Objects;

/**
 * Class InlineQuery.
 *
 *
 * @method int          getId()         Unique identifier for this query.
 * @method User         getFrom()       Sender.
 * @method string       getQuery()      Text of the query.
 * @method string       getOffset()     Offset of the results to be returned.
 * @link https://core.telegram.org/bots/api#inlinequery
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
