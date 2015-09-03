<?php

namespace Irazasyed\Telegram\Objects;

/**
 * Class UserProfilePhotos
 *
 * @package Irazasyed\Telegram\Objects
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
