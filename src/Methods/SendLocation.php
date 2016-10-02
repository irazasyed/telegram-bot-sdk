<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class SendLocation
 *
 * Send point on the map.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'latitude'             => '',
 *   'longitude'            => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendlocation
 *
 * @method SendLocation chatId($chatId) int|string
 * @method SendLocation latitude($latitude) float
 * @method SendLocation longitude($longitude) float
 * @method SendLocation disableNotification($bool) bool
 * @method SendLocation replyToMessageId($replyToMessageId) int
 * @method SendLocation replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 * @method Message go($dumpAndDie = false) Alias for getResult().
 */
class SendLocation extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}