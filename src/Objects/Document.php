<?php

namespace Irazasyed\Telegram\Objects;

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
