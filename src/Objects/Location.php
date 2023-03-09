<?php

namespace Telegram\Bot\Objects;

/**
 * Class Location.
 *
 * @link https://core.telegram.org/bots/api#location
 *
 * @property float      $longitude              Longitude as defined by sender.
 * @property float      $latitude               Latitude as defined by sender.
 * @property float|null $horizontalAccuracy     (Optional). The radius of uncertainty for the location, measured in meters; 0-1500
 * @property int|null   $livePeriod             (Optional). Time relative to the message sending date, during which the location can be updated, in seconds. For active live locations only.
 * @property int|null   $heading                (Optional). The direction in which user is moving, in degrees; 1-360. For active live locations only.
 * @property int|null   $proximityAlertRadius   (Optional). Maximum distance for proximity alerts about approaching another chat member, in meters. For sent live locations only.
 */
class Location extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
