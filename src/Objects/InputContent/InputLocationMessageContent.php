<?php

namespace Telegram\Bot\Objects\InputContent;

use Telegram\Bot\Objects\InlineQuery\InlineBaseObject;

/**
 * Class InputLocationMessageContent.
 *
 * <code>
 * $params = [
 *   'latitude'     => '',
 *   'longitude'    => '',
 *   'live_period'  => '',
 * ];
 *
 * @method $this setLatitude($float)    Latitude of the location in degrees
 * @method $this setLongitude($float)   Longitude of the location in degrees
 * @method $this setLivePeriod($int)    Optional. Period in seconds for which the location can be updated, should be between 60 and 86400.
 */
class InputLocationMessageContent extends InlineBaseObject
{
}
