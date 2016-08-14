<?php

namespace Telegram\Bot\Objects;

/**
 * Class Sticker.
 *
 *
 * @property string       $fileId     Unique identifier for this file.
 * @property int          $width      Sticker width.
 * @property int          $height     Sticker height.
 * @property PhotoSize    $thumb      (Optional). Sticker thumbnail in .webp or .jpg format.
 * @property string       $emoji      (Optional). Emoji associated with the sticker
 * @property int          $fileSize   (Optional). File size.
 */
class Sticker extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations()
    {
        return [
            'thumb' => PhotoSize::class,
        ];
    }
}
