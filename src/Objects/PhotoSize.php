<?php

namespace Telegram\Bot\Objects;

/**
 * Class PhotoSize.
 *
 * @link https://core.telegram.org/bots/api#photosize
 *
 * @property string $fileId Unique identifier for this file.
 * @property string $fileUniqueId Unique identifier for this file, which is supposed to be the same over time and for different bots. Can't be used to download or reuse the file.
 * @property int $width Photo width.
 * @property int $height Photo height.
 * @property int|null $fileSize (Optional). File size.
 */
class PhotoSize extends BaseObject
{
    /**
     * {@inheritdoc}
     */
    public function relations(): array
    {
        return [];
    }
}
