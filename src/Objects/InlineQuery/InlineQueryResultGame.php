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
 * @method InlineQueryResultGame setId($string) Unique identifier for this result, 1-64 Bytes.
 * @method InlineQueryResultGame setGameShortName($string) Short name of the game.
 * @method InlineQueryResultGame setReplyMarkup($object) Optional. Inline keyboard attached to the message
 */
class InlineQueryResultGame extends InlineBaseObject
{
    protected $type = 'game';
}
