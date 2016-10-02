<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class SendContact
 *
 * Send phone contacts.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'phone_number'         => '',
 *   'first_name'           => '',
 *   'last_name'            => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendcontact
 *
 * @method SendContact chatId($chatId) int|string
 * @method SendContact phoneNumber($phoneNumber) string
 * @method SendContact firstName($firstName) string
 * @method SendContact lastName($lastName) string
 * @method SendContact disableNotification($bool) bool
 * @method SendContact replyToMessageId($replyToMessageId) int
 * @method SendContact replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 * @method Message go($dumpAndDie = false) Alias for getResult().
 */
class SendContact extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}