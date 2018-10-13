<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultVenue.
 *
 * <code>
 * $params = [
 *   'id'                       => '',
 *   'latitude'                 => '',
 *   'longitude'                => '',
 *   'title'                    => '',
 *   'address'                  => '',
 *   'foursquare_id'            => '',
 *   'foursquare_type'          => '',
 *   'reply_markup'             => '',
 *   'input_message_content'    => '',
 *   'thumb_url'                => '',
 *   'thumb_width'              => '',
 *   'thumb_height'             => '',
 * ];
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvenue
 *
 * @method $this setId($string)                     Unique identifier for this result, 1-64 Bytes
 * @method $this setLatitude($float)                Latitude of the venue location in degrees
 * @method $this setLongitude($float)               Longitude of the venue location in degrees
 * @method $this setTitle($string)                  Title of the venue
 * @method $this setAddress($string)                Address of the venue
 * @method $this setFoursquareId($string)           Optional. Foursquare identifier of the venue if known
 * @method $this setFoursquareType($string)         Optional. Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 * @method $this setReplyMarkup($object)            Optional. Inline keyboard attached to the message
 * @method $this setInputMessageContent($object)    Optional. Content of the message to be sent instead of the venue
 * @method $this setThumbUrl($string)               Optional. Url of the thumbnail for the result
 * @method $this setThumbWidth($int)                Optional. Thumbnail width
 * @method $this setThumbHeight($int)               Optional. Thumbnail height
 */
class InlineQueryResultVenue extends InlineBaseObject
{
    protected $type = 'venue';
}
