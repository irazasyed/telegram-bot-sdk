<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class EditMessageText
 *
 * Use this method to edit text messages sent by the bot or via the bot (for inline bots).
 * On success, if edited message is sent by the bot, the edited Message is returned, otherwise True is returned.
 *
 * <code>
 * $params = [
 *   'chat_id'                  => '',
 *   'message_id'               => '',
 *   'inline_message_id'        => '',
 *   'text'                     => '',
 *   'parse_mode'               => '',
 *   'disable_web_page_preview' => '',
 *   'reply_markup'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#editmessagetext
 *
 * @method EditMessageText chatId($chatId) int|string
 * @method EditMessageText messageId($messageId) int
 * @method EditMessageText inlineMessageId($inlineMessageId) int
 * @method EditMessageText text($caption) string
 * @method EditMessageText parseMode($caption) string
 * @method EditMessageText disableWebPagePreview($disableWebPagePreview) bool
 * @method EditMessageText replyMarkup($replyMarkup) string
 *
 * @method Message|bool getResult($dumpAndDie = false)
 * @method Message|bool go($dumpAndDie = false) Alias for getResult().
 */
class EditMessageText extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}