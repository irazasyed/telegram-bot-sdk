<?php

namespace Telegram\Bot\Objects\InlineQuery;

/**
 * Class InlineQueryResultVenue.
 *
 * Represents a venue. By default, the venue will be sent by the user. Alternatively, you can use
 * input_message_content to send a message with the specified content instead of the venue.
 *
 * <code>
 * [
 *   'id'                     => '',  //  string                - Required. Unique identifier for this result, 1-64 Bytes
 *   'latitude'               => '',  //  float                 - Required. Latitude of the venue location in degrees
 *   'longitude'              => '',  //  float                 - Required. Longitude of the venue location in degrees
 *   'title'                  => '',  //  string                - Required. Title of the venue
 *   'address'                => '',  //  string                - Required. Address of the venue
 *   'foursquare_id'          => '',  //  string                - (Optional). Foursquare identifier of the venue if known
 *   'foursquare_type'        => '',  //  string                - (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 *   'google_place_id'        => '',  //  string                - (Optional). Google Places identifier of the venue
 *   'google_place_type'      => '',  //  string                - (Optional). Google Places type of the venue.
 *   'reply_markup'           => '',  //  InlineKeyboardMarkup  - (Optional). Inline keyboard attached to the message
 *   'input_message_content'  => '',  //  InputMessageContent   - (Optional). Content of the message to be sent instead of the venue
 *   'thumb_url'              => '',  //  string                - (Optional). Url of the thumbnail for the result
 *   'thumb_width'            => '',  //  int                   - (Optional). Thumbnail width
 *   'thumb_height'           => '',  //  int                   - (Optional). Thumbnail height
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inlinequeryresultvenue
 *
 * @method $this setId(string)                     Unique identifier for this result, 1-64 Bytes
 * @method $this setLatitude(float)                Latitude of the venue location in degrees
 * @method $this setLongitude(float)               Longitude of the venue location in degrees
 * @method $this setTitle(string)                  Title of the venue
 * @method $this setAddress(string)                Address of the venue
 * @method $this setFoursquareId(string)           (Optional). Foursquare identifier of the venue if known
 * @method $this setFoursquareType(string)         (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 * @method $this setReplyMarkup(object)            (Optional). Inline keyboard attached to the message
 * @method $this setInputMessageContent(object)    (Optional). Content of the message to be sent instead of the venue
 * @method $this setThumbUrl(string)               (Optional). Url of the thumbnail for the result
 * @method $this setThumbWidth(int)                (Optional). Thumbnail width
 * @method $this setThumbHeight(int)               (Optional). Thumbnail height
 */
class InlineQueryResultVenue extends InlineBaseObject
{
    protected $type = 'venue';
}
