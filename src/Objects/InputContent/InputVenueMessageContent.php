<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputVenueMessageContent.
 *
 * Represents the content of a venue message to be sent as the result of an inline query.
 *
 * <code>
 * [
 *   'latitude'          => '',  //  float   - Required. Latitude of the location in degrees
 *   'longitude'         => '',  //  float   - Required. Longitude of the location in degrees
 *   'title'             => '',  //  string  - Required. Name of the venue
 *   'address'           => '',  //  string  - Required. Address of the venue
 *   'foursquare_id'     => '',  //  string  - (Optional). Foursquare identifier of the venue, if known
 *   'foursquare_type'   => '',  //  string  - (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 *   'google_place_id'   => '',  //  string  - (Optional). Google Places identifier of the venue
 *   'google_place_type' => '',  //  string  - (Optional). Google Places type of the venue.
 * ]
 * </code>
 *
 * @link https://core.telegram.org/bots/api#inputvenuemessagecontent
 *
 * @method $this setLatitude(float)             Latitude of the location in degrees
 * @method $this setLongitude(float)            Longitude of the location in degrees
 * @method $this setTitle(string)               Name of the venue
 * @method $this setAddress(string)             Address of the venue
 * @method $this setFoursquareIdTitle(string)   (Optional). Foursquare identifier of the venue, if known
 * @method $this setFoursquareType(string)      (Optional). Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 */
class InputVenueMessageContent extends InlineBaseObject
{
}
