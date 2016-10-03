<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class SendGame
 *
 * Use this method to send a game. On success, the sent Message is returned.
 *
 * <code>
 * $params = [
 *   'chat_id'                  => '',
 *   'game_short_name'          => '',
 *   'disable_notification'     => '',
 *   'reply_to_message_id'      => '',
 *   'reply_markup'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendgame
 *
 * @method SendGame chatId($chatId) int|string
 * @method SendGame gameShortName($gameShortName) string
 * @method SendGame disableNotification($bool) bool
 * @method SendGame replyToMessageId($replyToMessageId) int
 * @method SendGame replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 * @method Message go($dumpAndDie = false) Alias for getResult().
 */
class SendGame extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}