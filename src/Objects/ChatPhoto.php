<?php

namespace Telegram\Bot\Objects;

/**
 * Class ChatPhoto.
 *
 *
 * @property string $smallFileId   Unique file identifier of small (160x160) chat photo. This file_id can be used only for photo download.
 * @property string $bigFileId     Unique file identifier of big (640x640) chat photo. This file_id can be used only for photo download.
 */
class ChatPhoto extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
