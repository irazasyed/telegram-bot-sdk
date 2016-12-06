<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class SetGameScore
 *
 * Use this method to set the score of the specified user in a game.
 * On success, if the message was sent by the bot, returns the edited Message, otherwise returns True.
 * Returns an error, if the new score is not greater than the user's current score in the chat.
 *
 * <code>
 * $params = [
 *   'user_id'              => '',
 *   'score'                => '',
 *   'force'                => '',
 *   'disable_edit_message' => '',
 *   'chat_id'              => '',
 *   'message_id'           => '',
 *   'inline_message_id'    => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendgame
 *
 * @method SetGameScore userId($userId) int
 * @method SetGameScore score($score) int
 * @method SetGameScore force($force) bool
 * @method SetGameScore disableEditMessage($disableEditMessage) bool
 * @method SetGameScore chatId($chatId) int|string
 * @method SetGameScore messageId($messageId) int
 * @method SetGameScore inlineMessageId($inlineMessageId) string
 *
 * @method Message getResult($dumpAndDie = false)
 */
class SetGameScore extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}