<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class EditMessageCaption
 *
 * Use this method to edit captions of messages sent by the bot or via the bot (for inline bots).
 * On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
 *
 * <code>
 * $params = [
 *   'chat_id'                  => '',
 *   'message_id'               => '',
 *   'inline_message_id'        => '',
 *   'caption'                  => '',
 *   'reply_markup'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#editmessagecaption
 *
 * @method EditMessageCaption chatId($chatId) int|string
 * @method EditMessageCaption messageId($messageId) int
 * @method EditMessageCaption inlineMessageId($inlineMessageId) int
 * @method EditMessageCaption caption($caption) string
 * @method EditMessageCaption replyMarkup($replyMarkup) string
 *
 * @method Message|bool getResult($dumpAndDie = false)
 */
class EditMessageCaption extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}