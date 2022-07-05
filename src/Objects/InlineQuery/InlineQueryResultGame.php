<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultGame.
 *
 * <code>
 * $params = [
 *   'id'              => '',
 *   'game_short_name' => '',
 *   'reply_markup'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultgame
 *
 * @method $this setId(string)             Unique identifier for this result, 1-64 Bytes.
 * @method $this setGameShortName(string)  Short name of the game.
 * @method $this setReplyMarkup(object)    (Optional). Inline keyboard attached to the message
 */
class InlineQueryResultGame extends InlineBaseObject
{
    protected $type = 'game';
}
