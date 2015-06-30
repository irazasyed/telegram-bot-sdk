<?php

namespace Irazasyed\Telegram\Objects;

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
