<?php

namespace Telegram\Bot\Objects;

/**
 * Class Document
 *
 * @package Telegram\Bot\Objects
 */
class Document extends BaseObject
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
