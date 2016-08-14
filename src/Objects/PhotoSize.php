<?php

namespace Telegram\Bot\Objects;

/**
 * Class PhotoSize.
 *
 *
 * @property string   $fileId     Unique identifier for this file.
 * @property int      $width      Photo width.
 * @property int      $height     Photo height.
 * @property int      $fileSize   (Optional). File size.
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
