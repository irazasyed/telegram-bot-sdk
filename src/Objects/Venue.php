<?php

namespace Telegram\Bot\Objects;

/**
 * Class Venue.
 *
 * @link https://core.telegram.org/bots/api#venue
 *
 * @property Location    $location          Venue location.
 * @property string      $title             Name of the venue.
 * @property string      $address           Address of the venue.
 * @property string|null $foursquareId      (Optional). Foursquare identifier of the venue.
 * @property string|null $foursquareType    (Optional). Foursquare type of the venue. (For example, “arts_entertainment/default”, “arts_entertainment/aquarium” or “food/icecream”.)
 * @property string|null $googlePlaceId     (Optional). Google Places identifier of the venue
 * @property string|null $googlePlaceType   (Optional). Google Places type of the venue. (
 */
class Venue extends BaseObject
{
    /**
     * {@inheritdoc}
     *
     * @return array{location: string}
     */
    public function relations(): array
    {
        return [
            'location' => Location::class,
        ];
    }
}
