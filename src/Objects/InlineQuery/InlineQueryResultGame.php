<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultGame.
 *
 * Represents a Game.
 *
 * <code>
 * [
 *   'id'               => '',  //  string                - Required. Unique identifier for this result, 1-64 Bytes.
 *   'game_short_name'  => '',  //  string                - Required. Short name of the game.
 *   'reply_markup'     => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultgame
 *
 * @method $this setId(string) Unique identifier for this result, 1-64 Bytes.
 * @method $this setGameShortName(string) Short name of the game.
 * @method $this setReplyMarkup(object) (Optional). Inline keyboard attached to the message
 */
class InlineQueryResultGame extends InlineBaseObject
{
    protected $type = 'game';
}
