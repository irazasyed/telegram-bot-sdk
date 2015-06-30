<?php

namespace Irazasyed\Telegram\Objects;

class Update extends BaseObject
{
    /**
     * @inheritdoc
     */
    public function relations()
    {
        return [
            'message' => Message::class
        ];
    }
}