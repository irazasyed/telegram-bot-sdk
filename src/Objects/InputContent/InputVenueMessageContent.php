<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputVenueMessageContent
 *
 * <code>
 * $params = [
 *   'latitude'         => '',
 *   'longitude'        => '',
 *   'title'            => '',
 *   'address'          => '',
 *   'foursquare_id'    => '',
 * ];
 * </code>
 *
 * @method $this setLatitude($float)             Latitude of the location in degrees
 * @method $this setLongitude($float)            Longitude of the location in degrees
 * @method $this setTitle($string)               Name of the venue
 * @method $this setAddress($string)             Address of the venue
 * @method $this setFoursquareIdTitle($string)   Optional. Foursquare identifier of the venue, if known
 */
class InputVenueMessageContent extends InlineBaseObject
{

}
