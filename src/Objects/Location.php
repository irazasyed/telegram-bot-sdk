<?php

namespace Telegram\Bot\Objects;

/**
 * Class Location.
 *
 *
 * @property float    $longitude  Longitude as defined by sender.
 * @property float    $latitude   Latitude as defined by sender.
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
