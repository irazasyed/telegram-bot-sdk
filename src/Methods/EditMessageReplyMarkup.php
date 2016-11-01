<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class EditMessageReplyMarkup
 *
 * Use this method to edit only the reply markup of messages sent by the bot or via the bot (for inline bots).
 * On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
 *
 * <code>
 * $params = [
 *   'chat_id'                  => '',
 *   'message_id'               => '',
 *   'inline_message_id'        => '',
 *   'reply_markup'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#editmessagereplymarkup
 *
 * @method EditMessageReplyMarkup chatId($chatId) int|string
 * @method EditMessageReplyMarkup messageId($messageId) int
 * @method EditMessageReplyMarkup inlineMessageId($inlineMessageId) int
 * @method EditMessageReplyMarkup replyMarkup($replyMarkup) string
 *
 * @method Message|bool getResult($dumpAndDie = false)
 */
class EditMessageReplyMarkup extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}