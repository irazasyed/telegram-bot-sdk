<?php

namespace Telegram\Bot\Objects;

/**
 * Class UserProfilePhotos.
 *
 *
 * @property int          $totalCount     Total number of profile pictures the target user has.
 * @property PhotoSize[]  $photos         Requested profile pictures (in up to 4 sizes each).
 */
class UserProfilePhotos extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'photos' => PhotoSize::class,
        ];
    }
}
