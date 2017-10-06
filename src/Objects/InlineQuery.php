<?php

namespace Telegram\Bot\Objects;

/**
 * Class InlineQuery.
 *
 *
 * @property int          $id         Unique identifier for this query.
 * @property User         $from       Sender.
 * @property Location     $location   (Optional). Sender location, only for bots that request user location.
 * @property string       $query      Text of the query.
 * @property string       $offset     Offset of the results to be returned.
 *
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
            'from'     => User::class,
            'location' => Location::class,
        ];
    }
}
