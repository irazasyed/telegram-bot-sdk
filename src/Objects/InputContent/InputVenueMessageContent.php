<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputVenueMessageContent.
 *
 * <code>
 * $params = [
 *   'latitude'         => '',
 *   'longitude'        => '',
 *   'title'            => '',
 *   'address'          => '',
 *   'foursquare_id'    => '',
 *   'foursquare_type'  => '',
 * ];
 * </code>
 *
 * @method $this setLatitude($float)             Latitude of the location in degrees
 * @method $this setLongitude($float)            Longitude of the location in degrees
 * @method $this setTitle($string)               Name of the venue
 * @method $this setAddress($string)             Address of the venue
 * @method $this setFoursquareIdTitle($string)   Optional. Foursquare identifier of the venue, if known
 * @method $this setFoursquareType($string)      Optional. Foursquare type of the venue, if known. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 */
class InputVenueMessageContent extends InlineBaseObject
{
}
