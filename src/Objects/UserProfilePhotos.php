<?php

namespace Telegram\Bot\Objects;

/**
 * Class UserProfilePhotos
 *
 * @package Telegram\Bot\Objects
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
