<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class SendMessage
 *
 * Send text messages.
 *
 * <code>
 * $params = [
 *   'chat_id'                  => '',
 *   'text'                     => '',
 *   'parse_mode'               => '',
 *   'disable_web_page_preview' => '',
 *   'disable_notification'     => '',
 *   'reply_to_message_id'      => '',
 *   'reply_markup'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendmessage
 *
 * @method SendMessage chatId($chatId) int|string
 * @method SendMessage text($text) string
 * @method SendMessage parseMode($parseMode) string
 * @method SendMessage disableWebPagePreview($bool) bool
 * @method SendMessage disableNotification($bool) bool
 * @method SendMessage replyToMessageId($replyToMessageId) int
 * @method SendMessage replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 */
class SendMessage extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}