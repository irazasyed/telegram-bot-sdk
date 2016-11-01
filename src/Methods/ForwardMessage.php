<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class ForwardMessage
 *
 * Forward messages of any kind.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'from_chat_id'         => '',
 *   'disable_notification' => '',
 *   'message_id'           => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#forwardmessage
 *
 * @method ForwardMessage chatId($chatId) int|string
 * @method ForwardMessage fromChatId($fromChatId) int
 * @method ForwardMessage disableNotification($bool) bool
 * @method ForwardMessage messageId($messageId) int
 *
 * @method Message getResult($dumpAndDie = false)
 */
class ForwardMessage extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}