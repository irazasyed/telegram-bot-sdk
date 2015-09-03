<?php

namespace Irazasyed\Telegram\Objects;

/**
 * Class Sticker
 *
 * @package Irazasyed\Telegram\Objects
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
