<?php

namespace Telegram\Bot\Objects;

/**
 * Class Sticker
 *
 * @package Telegram\Bot\Objects
 */
class Sticker extends BaseObject
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
