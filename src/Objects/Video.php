<?php

namespace Irazasyed\Telegram\Objects;

class Video extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'thumb' => PhotoSize::class
        ];
    }
}