<?php

namespace Telegram\Bot\Objects;

/**
 * Class Video
 *
 * @package Telegram\Bot\Objects
 */
class Video extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
