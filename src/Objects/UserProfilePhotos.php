<?php

namespace Telegram\Bot\Objects;

/**
 * Class UserProfilePhotos
 *
 * @package Telegram\Bot\Objects
 *
 * @method int          getTotalCount()     Total number of profile pictures the target user has.
 * @method PhotoSize[]  getPhotos()         Requested profile pictures (in up to 4 sizes each).
 */
class UserProfilePhotos extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'photos' => PhotoSize::class,
        ];
    }
}
