<?php
namespace Telegram\Bot\Methods;

use Telegram\Bot\Objects\Message;

/**
 * Class SendVenue
 *
 * Send information about a venue.
 *
 * <code>
 * $params = [
 *   'chat_id'              => '',
 *   'latitude'             => '',
 *   'longitude'            => '',
 *   'title'                => '',
 *   'address'              => '',
 *   'foursquare_id'        => '',
 *   'disable_notification' => '',
 *   'reply_to_message_id'  => '',
 *   'reply_markup'         => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#sendvenue
 *
 * @method SendVenue chatId($chatId) int|string
 * @method SendVenue latitude($latitude) float
 * @method SendVenue longitude($longitude) float
 * @method SendVenue title($title) string
 * @method SendVenue address($title) string
 * @method SendVenue foursquareId($foursquareId) string
 * @method SendVenue disableNotification($bool) bool
 * @method SendVenue replyToMessageId($replyToMessageId) int
 * @method SendVenue replyMarkup($replyMarkup) string
 *
 * @method Message getResult($dumpAndDie = false)
 * @method Message go($dumpAndDie = false) Alias for getResult().
 */
class SendVenue extends Method
{
    /** {@inheritdoc} */
    protected function returns()
    {
        return Message::class;
    }
}