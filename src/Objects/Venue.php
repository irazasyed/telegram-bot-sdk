<?php

namespace Telegram\Bot\Objects;

/**
 * Class Venue.
 *
 *
 * @property Location    $location        Venue location.
 * @property string      $title           Name of the venue.
 * @property string      $address         Address of the venue.
 * @property string      $foursquareId    (Optional). Foursquare identifier of the venue.
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
