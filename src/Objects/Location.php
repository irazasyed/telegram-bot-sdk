<?php

namespace Telegram\Bot\Objects;

/**
 * Class Location.
 *
 *
 * @method float    getLongitude()  Longitude as defined by sender.
 * @method float    getLatitude()   Latitude as defined by sender.
 */
class Location extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
