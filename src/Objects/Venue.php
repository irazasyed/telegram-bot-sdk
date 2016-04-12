<?php

namespace Telegram\Bot\Objects;

/**
 * Class Venue.
 *
 *
 * @method Location    getLocation()        Venue location.
 * @method string      getTitle()           Name of the venue.
 * @method string      getAddress()         Address of the venue.
 * @method string      getFoursquareId()    (Optional). Foursquare identifier of the venue.
 */
class Venue extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'location' => Location::class,
        ];
    }
}
