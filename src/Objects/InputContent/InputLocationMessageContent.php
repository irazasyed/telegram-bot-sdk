<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputLocationMessageContent.
 *
 * Represents the content of a location message to be sent as the result of an inline query.
 *
 * <code>
 * [
 *   'latitude'               => '',  //  float  - Required. Latitude of the location in degrees
 *   'longitude'              => '',  //  float  - Required. Longitude of the location in degrees
 *   'horizontal_accuracy'    => '',  //  float  - (Optional). The radius of uncertainty for the location, measured in meters; 0-1500
 *   'live_period'            => '',  //  int    - (Optional). Period in seconds for which the location can be updated, should be between 60 and 86400.
 *   'heading'                => '',  //  int    - (Optional). For live locations, a direction in which the user is moving, in degrees. Must be between 1 and 360 if specified.
 *   'proximity_alert_radius' => '',  //  int    - (Optional). For live locations, a maximum distance for proximity alerts about approaching another chat member, in meters. Must be between 1 and 100000 if specified.
 * ]
 *
 * @link https://core.telegram.org/bots/api#inputlocationmessagecontent
 *
 * @method $this setLatitude(float)    Latitude of the location in degrees
 * @method $this setLongitude(float)   Longitude of the location in degrees
 * @method $this setLivePeriod(int)    (Optional). Period in seconds for which the location can be updated, should be between 60 and 86400.
 */
class InputLocationMessageContent extends InlineBaseObject
{
}
