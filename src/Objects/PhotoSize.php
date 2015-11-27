<?php

namespace Telegram\Bot\Objects;

/**
 * Class PhotoSize.
 *
 *
 * @method string   getFileId()     Unique identifier for this file.
 * @method int      getWidth()      Photo width.
 * @method int      getHeight()     Photo height.
 * @method int      getFileSize()   (Optional). File size.
 */
class PhotoSize extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [];
    }
}
